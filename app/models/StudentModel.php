<?php


class StudentModel extends Model
{
    public function createRequest($studentId, $tutorId, $subject, $message)
    {
        $stmt = $this->db->prepare("INSERT INTO tutoring_requests (student_id, tutor_id, subject, message, status, submitted_at)
        VALUES (?, ?, ?, ?, 'pending', NOW())");
        $stmt->execute([$studentId, $tutorId, $subject, $message]);
    }
    public function getRequestsByStudent($studentId)
    {
        $stmt = $this->db->prepare("
        SELECT r.request_id, t.name AS tutor_name, t.subject AS tutor_subject, r.subject, r.message, r.status, r.submitted_at
        FROM tutoring_requests r
        JOIN tutors t ON r.tutor_id = t.tutor_id
        WHERE r.student_id = ?
        ORDER BY r.submitted_at DESC
    ");
        $stmt->execute([$studentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
