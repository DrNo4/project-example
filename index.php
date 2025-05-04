<?php
// Include database connection and helper functions
require_once 'config/db.php';
require_once 'includes/functions.php';

// Get all contacts
$contacts = getAllContacts();

// Handle search query
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchQuery = $_GET['search'];
    $contacts = searchContacts($searchQuery);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Contacts App</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Contacts</h1>
        
        <div class="actions">
            <a href="add.php" class="btn">Add New Contact</a>
            
            <form action="index.php" method="GET" class="search-form">
                <input type="text" name="search" placeholder="Search contacts..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button type="submit">Search</button>
                <?php if (isset($_GET['search']) && !empty($_GET['search'])): ?>
                    <a href="index.php">Clear</a>
                <?php endif; ?>
            </form>
        </div>
        
        <?php if (empty($contacts)): ?>
            <p>No contacts found.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contacts as $contact): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($contact['first_name'] . ' ' . $contact['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($contact['phone']); ?></td>
                            <td><?php echo htmlspecialchars($contact['email']); ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $contact['id']; ?>" class="btn-edit">Edit</a>
                                <a href="delete.php?id=<?php echo $contact['id']; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this contact?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
