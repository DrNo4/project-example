<?php
/**
 * Get all contacts from the database
 * 
 * @return array Array of contacts
 */
function getAllContacts() {
    global $pdo;
    
    try {
        $stmt = $pdo->query("SELECT * FROM contacts ORDER BY last_name, first_name");
        return $stmt->fetchAll();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    }
}

/**
 * Get a single contact by ID
 * 
 * @param int $id Contact ID
 * @return array|false Contact data or false if not found
 */
function getContactById($id) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM contacts WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

/**
 * Add a new contact
 * 
 * @param array $data Contact data
 * @return bool Success status
 */
function addContact($data) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("
            INSERT INTO contacts (first_name, last_name, phone, email) 
            VALUES (:first_name, :last_name, :phone, :email)
        ");
        
        $stmt->bindParam(':first_name', $data['first_name'], PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $data['last_name'], PDO::PARAM_STR);
        $stmt->bindParam(':phone', $data['phone'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
        
        return $stmt->execute();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

/**
 * Update an existing contact
 * 
 * @param int $id Contact ID
 * @param array $data Updated contact data
 * @return bool Success status
 */
function updateContact($id, $data) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("
            UPDATE contacts 
            SET first_name = :first_name, 
                last_name = :last_name, 
                phone = :phone, 
                email = :email 
            WHERE id = :id
        ");
        
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':first_name', $data['first_name'], PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $data['last_name'], PDO::PARAM_STR);
        $stmt->bindParam(':phone', $data['phone'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
        
        return $stmt->execute();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

/**
 * Delete a contact
 * 
 * @param int $id Contact ID
 * @return bool Success status
 */
function deleteContact($id) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("DELETE FROM contacts WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

/**
 * Search contacts by name, phone or email
 * 
 * @param string $query Search query
 * @return array Array of matching contacts
 */
function searchContacts($query) {
    global $pdo;
    
    try {
        $searchTerm = "%$query%";
        
        $stmt = $pdo->prepare("
            SELECT * FROM contacts 
            WHERE first_name LIKE :search 
            OR last_name LIKE :search 
            OR phone LIKE :search 
            OR email LIKE :search
            ORDER BY last_name, first_name
        ");
        
        $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchAll();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    }
}

/**
 * Validate contact data
 * 
 * @param array $data Contact data to validate
 * @return array Array of error messages (empty if no errors)
 */
function validateContactData($data) {
    $errors = [];
    
    // Validate first name
    if (empty($data['first_name'])) {
        $errors['first_name'] = "First name is required";
    }
    
    // Validate last name
    if (empty($data['last_name'])) {
        $errors['last_name'] = "Last name is required";
    }
    
    // Validate phone
    if (empty($data['phone'])) {
        $errors['phone'] = "Phone number is required";
    }
    
    // Validate email
    if (empty($data['email'])) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }
    
    return $errors;
} 