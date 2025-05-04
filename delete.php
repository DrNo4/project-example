<?php
// Include database connection and helper functions
require_once 'config/db.php';
require_once 'includes/functions.php';

// Check if ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Redirect to index if no ID provided
    header('Location: index.php');
    exit;
}

$id = (int)$_GET['id'];

// Check if contact exists
$contact = getContactById($id);

if (!$contact) {
    // Redirect to index if contact not found
    header('Location: index.php');
    exit;
}

// Delete the contact
if (deleteContact($id)) {
    // Set success message in session if desired
    // $_SESSION['message'] = "Contact deleted successfully.";
} else {
    // Set error message in session if desired
    // $_SESSION['error'] = "Failed to delete contact.";
}

// Redirect back to index
header('Location: index.php');
exit; 