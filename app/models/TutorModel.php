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
            $stmt = $this->db->prepare("INSERT INTO TutorAvailability (tutor_id, day_of_week, start_time, end_time) VALUES (?, ?, ?, ?)");
            $stmt->execute([$tutorId, $day, $times['start'], $times['end']]);
        }
    }

    public function isEmailTaken($email)
    {
        $db = $this->db;
        $stmt = $db->prepare("SELECT COUNT(*) FROM tutors WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }
}
