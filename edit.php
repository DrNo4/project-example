<?php
// Include database connection and helper functions
require_once 'config/db.php';
require_once 'includes/functions.php';

// Initialize variables
$errors = [];
$contact = [
    'id' => '',
    'first_name' => '',
    'last_name' => '',
    'phone' => '',
    'email' => ''
];

// Check if ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Redirect to index if no ID provided
    header('Location: index.php');
    exit;
}

$id = (int)$_GET['id'];

// Get contact data
$contact = getContactById($id);

// If contact not found, redirect to index
if (!$contact) {
    header('Location: index.php');
    exit;
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input data
    $updatedContact = [
        'first_name' => trim($_POST['first_name']),
        'last_name' => trim($_POST['last_name']),
        'phone' => trim($_POST['phone']),
        'email' => trim($_POST['email'])
    ];
    
    // Validate contact data
    $errors = validateContactData($updatedContact);
    
    // If no errors, update contact in database
    if (empty($errors)) {
        if (updateContact($id, $updatedContact)) {
            // Redirect to index page on success
            header('Location: index.php');
            exit;
        } else {
            $errors['db'] = "Failed to update the contact. Please try again.";
        }
    }
    
    // Update contact variable with form data for re-display
    $contact = array_merge($contact, $updatedContact);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Contact - PHP Contacts App</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Edit Contact</h1>
        
        <a href="index.php" class="back-link">Back to Contacts</a>
        
        <?php if (isset($errors['db'])): ?>
            <div class="alert alert-error">
                <?php echo $errors['db']; ?>
            </div>
        <?php endif; ?>
        
        <form action="edit.php?id=<?php echo $id; ?>" method="POST" class="contact-form">
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($contact['first_name']); ?>" required>
                <?php if (isset($errors['first_name'])): ?>
                    <div class="error"><?php echo $errors['first_name']; ?></div>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($contact['last_name']); ?>" required>
                <?php if (isset($errors['last_name'])): ?>
                    <div class="error"><?php echo $errors['last_name']; ?></div>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($contact['phone']); ?>" required>
                <?php if (isset($errors['phone'])): ?>
                    <div class="error"><?php echo $errors['phone']; ?></div>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($contact['email']); ?>" required>
                <?php if (isset($errors['email'])): ?>
                    <div class="error"><?php echo $errors['email']; ?></div>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn">Update Contact</button>
            </div>
        </form>
    </div>
</body>
</html> 