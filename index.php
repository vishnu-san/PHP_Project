<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management</title>
    <style>
body {
    font-family: Arial, sans-serif;
    background: #f0f0f0; 
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    min-height: 100vh;
    margin: 0;
}

h1 {
    text-align: center;
    margin-bottom: 20px;
    text-shadow: 1px 1px 2px #aaa;
}

form {
    margin-bottom: 20px;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    max-width: 600px;
    width: 100%;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background: #fff;
    transform: perspective(1000px) rotateX(5deg);
    transform-style: preserve-3d;
}

label {
    display: block;
    margin-top: 10px;
    text-align: left; 
}

input, select {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    box-sizing: border-box;
    border-radius: 5px;
    border: 1px solid #ccc;
    box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
}

button {
    margin-top: 10px;
    padding: 10px 15px;
    background-color: #007BFF;
    border: none;
    color: white;
    cursor: pointer;
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
}

button:hover {
    background-color: #0056b3;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
}

table {
    width: 80%; 
    border-collapse: collapse;
    margin: 20px auto; 
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background: #fff;
    transform: perspective(1000px) rotateX(5deg);
    transform-style: preserve-3d;
}

table, th, td {
    border: 1px solid #ccc;
}

th, td {
    padding: 5px; 
    text-align: left;
    font-size: 14px; 
}

th {
    background-color: #f2f2f2;
}

table button {
    padding: 5px 10px;
    margin: 2px;
    background-color: #007BFF;
    border: none;
    color: white;
    cursor: pointer;
    border-radius: 3px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
}

table button:hover {
    background-color: #0056b3;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

</style>
</head>
<body>
    <h1>User Management</h1>

    <form id="userForm">
        <input type="hidden" id="userId" name="id">
        <input type="hidden" id="action" name="action" value="add">
        
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required placeholder="ex: Shank">
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required placeholder="ex: Shank@gmail.com">
        
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" required placeholder="ex: 1234567890">
        
        <label for="dob">DOB:</label>
        <input type="date" id="dob" name="dob">
        
        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="">Select</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select>
        
        <button type="submit">Submit</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>DOB</th>
                <th>Gender</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $conn->query("SELECT * FROM users");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['phone'] . "</td>";
                echo "<td>" . $row['dob'] . "</td>";
                echo "<td>" . $row['gender'] . "</td>";
                echo "<td>
                        <button onclick='editUser(" . $row['id'] . ")'>Edit</button>
                        <button onclick='deleteUser(" . $row['id'] . ")'>Delete</button>
                      </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('userForm');
    
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        fetch('process.php', {
            method: 'POST',
            body: formData
        }).then(response => response.text()).then(data => {
            location.reload();
        }).catch(error => console.error('Error:', error));
    });
});

function editUser(id) {
    fetch(`get_user.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('userId').value = data.id;
            document.getElementById('name').value = data.name;
            document.getElementById('email').value = data.email;
            document.getElementById('phone').value = data.phone;
            document.getElementById('dob').value = data.dob;
            document.getElementById('gender').value = data.gender;
            document.getElementById('action').value = 'update';
        });
}

function deleteUser(id) {
    if (confirm('Are you sure you want to delete this user?')) {
        fetch(`process.php?delete=${id}`)
            .then(response => response.text())
            .then(data => {
                location.reload();
            });
    }
}

    </script>
</body>
</html>
