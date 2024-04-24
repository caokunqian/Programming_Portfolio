<?php
session_start();

// an empty array for the to-do list
if (!isset($_SESSION['todos'])) {
    $_SESSION['todos'] = [];
}

//form submission 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = $_POST['event_id'] ?? '';
    $description = $_POST['description'] ?? '';
    $due_date = $_POST['due_date'] ?? '';

    if ($event_id !== '') {
        // Edit the existing one
        $_SESSION['todos'][$event_id] = ['description' => $description, 'due_date' => $due_date];
    } else {
        // add another one
        $_SESSION['todos'][] = ['description' => $description, 'due_date' => $due_date];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f9; }
        .title { font-size: 28px; text-align: center; margin-top: 20px; background-image: linear-gradient(to right, red, orange, yellow, green, blue, indigo, violet); color: transparent; -webkit-background-clip: text; }
        .instructions { background: beige; padding: 10px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin: 10px auto; font-size: 16px; text-align: center; max-width: 600px; }
        .todo-container { max-width: 600px; margin: 20px auto; padding: 10px; }
        .todo-item { background: #fff; border: 1px solid #ddd; padding: 10px; margin-bottom: 10px; }
        .todo-form { text-align: center; padding: 10px; }
        .button { padding: 8px 16px; margin: 10px; font-size: 18px; cursor: pointer; }
        input[type="text"], input[type="date"] { margin: 5px 0; padding: 8px; width: 70%; }
        .back-to-main-button {
    position: fixed; /* Fixed position */
    top: 10px; /* 10px from the top */
    right: 10px; /* 10px from the right */
    background-color: #FF3B30; /* Red background */
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    z-index: 1000; /* Make sure it's above other items */
}

.back-to-main-button:hover {
    background-color: #4CAF50; /* Green background on hover */
}

    </style>
</head>
<body>
<button class="back-to-main-button" onclick="window.location.href='index.php';">Back to Main Page</button>

    <h1 class="title">To-Do List</h1>
    <div class="instructions">
        <p>This is a great To-Do List Management System. </p>
        <p>Add your tasks below with a description and due date. Edit them as needed.</p>
    </div>

    <div class="todo-container">
        <?php foreach ($_SESSION['todos'] as $id => $todo): ?>
            <div class="todo-item">
                <form action="script5.php" method="post">
                    <input type="hidden" name="event_id" value="<?= $id ?>">
                    <div>
                        <input type="text" name="description" placeholder="Description" value="<?= htmlspecialchars($todo['description']) ?>">
                    </div>
                    <div>
                        <input type="date" name="due_date" value="<?= $todo['due_date'] ?>">
                    </div>
                    <button type="submit" class="button">Update Task</button>
                </form>
            </div>
        <?php endforeach; ?>
        <div class="todo-form">
            <form action="script5.php" method="post">
                <input type="text" name="description" placeholder="New Task Description">
                <input type="date" name="due_date">
                <button type="submit" class="button">Add Task</button>
                
            </form>
        </div>
    </div>
</body>
</html>
