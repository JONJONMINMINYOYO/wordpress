<!DOCTYPE html>
<html>
<head>
    <title>PHP Form Example</title>
</head>
<body>
    <h2>PHP Form Example</h2>
    <?php
    // Check if form is submitteds
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];
        $dropdown = $_POST['dropdown'];

        // Display submitted data
        echo "<h3>Submitted Information:</h3>";
        echo "<p>Name: $name</p>";
        echo "<p>Email: $email</p>";
        echo "<p>Message: $message</p>";
        echo "<p>Selected option: $dropdown</p>";
    }
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name"><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email"><br><br>

        <label for="message">Message:</label><br>
        <textarea id="message" name="message" rows="4" cols="50"></textarea><br><br>

        <label for="dropdown">Choose an option:</label>
        <select id="dropdown" name="dropdown">
            <option value="option1">Option 1</option>
            <option value="option2">Option 2</option>
            <option value="option3">Option 3</option>
        </select><br><br>

        <input type="submit" name="submit" value="Submit">
    </form>
    <div>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name">
            </div>

            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email">
            </div>

            <div>
                <label for="message">Message:</label><br>
                <textarea id="message" name="message" rows="4" cols="50"></textarea>
            </div>

            <div>
                <label for="dropdown">Choose an option:</label>
                <select id="dropdown" name="dropdown">
                    <option value="option1">Option 1</option>
                    <option value="option2">Option 2</option>
                    <option value="option3">Option 3</option>
                </select>
            </div>

            <div>
                <input type="submit" name="submit" value="Submit">
            </div>
        </form>
    </div>
</body>
</html>
