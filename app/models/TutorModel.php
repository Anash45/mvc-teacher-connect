<?php


class TutorModel extends Model
{
    public function getAllTutors()
    {
        $stmt = $this->db->query("SELECT * FROM tutors ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createTutor($name, $subject, $bio, $email, $imagePath, $availability)
    {
        $stmt = $this->db->prepare("INSERT INTO Tutors (name, subject, bio, email, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $subject, $bio, $email, $imagePath]);
        $tutorId = $this->db->lastInsertId();

        foreach ($availability as $day => $times) {
            $start = !empty($times['start']) ? $times['start'] : null;
            $end = !empty($times['end']) ? $times['end'] : null;

            if ($start != null && $end != null) {
                $stmt = $this->db->prepare("INSERT INTO TutorAvailability (tutor_id, day_of_week, start_time, end_time) VALUES (?, ?, ?, ?)");
                $stmt->execute([$tutorId, $day, $start, $end]);
            }
        }
    }
    
    public function getAllRequests()
    {
        $stmt = $this->db->prepare("
        SELECT r.request_id, t.name AS tutor_name, u.name AS student_name, t.subject AS tutor_subject, r.subject, r.message, r.status, r.submitted_at
        FROM tutoring_requests r
        JOIN users u ON r.student_id = u.user_id
        JOIN tutors t ON r.tutor_id = t.tutor_id
        ORDER BY r.submitted_at DESC
    ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function isEmailTaken($email)
    {
        $db = $this->db;
        $stmt = $db->prepare("SELECT COUNT(*) FROM tutors WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }

    public function getTutorById($id)
    {
        // Fetch tutor basic details
        $stmt = $this->db->prepare("SELECT * FROM tutors WHERE tutor_id = ?");
        $stmt->execute([$id]);
        $tutor = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$tutor) {
            return null; // Tutor not found
        }

        // Fetch availability
        $availabilityStmt = $this->db->prepare("SELECT * FROM tutoravailability WHERE tutor_id = ?");
        $availabilityStmt->execute([$id]);
        $availabilityRows = $availabilityStmt->fetchAll(PDO::FETCH_ASSOC);

        $availability = [];
        foreach ($availabilityRows as $row) {
            $availability[$row['day_of_week']] = [
                'start_time' => $row['start_time'],
                'end_time' => $row['end_time']
            ];
        }

        // Combine and return
        $tutor['availability'] = $availability;
        return $tutor;
    }

    public function updateTutor($id, $name, $subject, $bio, $email, $imagePath, $availability)
    {
        $stmt = $this->db->prepare("UPDATE Tutors SET name=?, subject=?, bio=?, email=?, image=? WHERE tutor_id=?");
        $stmt->execute([$name, $subject, $bio, $email, $imagePath, $id]);

        $this->db->prepare("DELETE FROM tutoravailability WHERE tutor_id = ?")->execute([$id]);

        foreach ($availability as $day => $times) {
            $start = !empty($times['start']) ? $times['start'] : null;
            $end = !empty($times['end']) ? $times['end'] : null;

            if ($start !== null || $end !== null) {
                $stmt = $this->db->prepare("INSERT INTO tutoravailability (tutor_id, day_of_week, start_time, end_time) VALUES (?, ?, ?, ?)");
                $stmt->execute([$id, $day, $start, $end]);
            }
        }
    }

    public function searchTutors($query = '')
    {
        if (!empty($query)) {
            $stmt = $this->db->prepare("SELECT * FROM tutors WHERE name LIKE ? OR subject LIKE ?");
            $search = '%' . $query . '%';
            $stmt->execute([$search, $search]);
        } else {
            $stmt = $this->db->query("SELECT * FROM tutors");
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteTutor($id)
    {
        // Delete availability first to maintain FK integrity
        $this->db->prepare("DELETE FROM tutoravailability WHERE tutor_id = ?")->execute([$id]);

        // Then delete the tutor
        $this->db->prepare("DELETE FROM tutors WHERE tutor_id = ?")->execute([$id]);
    }

}
