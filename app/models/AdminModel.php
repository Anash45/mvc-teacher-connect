<?php


class AdminModel extends Model
{
    public function updateRequestStatus($requestId, $status)
    {
        $allowed = ['pending', 'accepted', 'rejected'];
        if (!in_array($status, $allowed)) {
            return false;
        }

        $stmt = $this->db->prepare("UPDATE tutoring_requests SET status = ? WHERE request_id = ?");
        return $stmt->execute([$status, $requestId]);
    }

}
