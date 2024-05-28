<?php
include('connect.php');
session_start();

// Function to create or update XML file with new contact data
function updateXMLFile($name, $email, $message)
{
    $xmlFile = 'contacts.xml';
    $xml = new DOMDocument('1.0', 'utf-8');
    $xml->formatOutput = true;

    // Check if XML file exists
    if (file_exists($xmlFile)) {
        $xml->load($xmlFile);
        $root = $xml->documentElement;
    } else {
        $root = $xml->createElement('contacts');
        $xml->appendChild($root);
    }

    // Get the last contact ID to determine the next available ID
    $contacts = $xml->getElementsByTagName('contact');
    $lastContact = $contacts->item($contacts->length - 1);
    $lastID = $lastContact !== null && $lastContact->hasAttribute('id') ? intval($lastContact->getAttribute('id')) : 0;
    $nextID = $lastID + 1;

    // Create new contact node with ID attribute
    $contact = $xml->createElement('contact');
    $contact->setAttribute('id', $nextID);
    $contact->appendChild($xml->createElement('name', $name));
    $contact->appendChild($xml->createElement('email', $email));
    $contact->appendChild($xml->createElement('message', $message));
    
    // Add current date
    $date = date('Y-m-d H:i:s');
    $contact->appendChild($xml->createElement('date', $date));

    // Append contact node to root
    $root->appendChild($contact);

    // Save XML to file
    $xml->save($xmlFile);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate form inputs
    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])) {
        // Sanitize input data
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $message = mysqli_real_escape_string($con, $_POST['message']);

        // Update XML file with new contact data
        updateXMLFile($name, $email, $message);

        // Redirect with JavaScript alert
        echo '<script>alert("Message sent successfully!");</script>';
        echo '<script>window.location.href = "index.php";</script>';
        exit(); // Terminate script execution
    } else {
        // Handle missing parameters
        echo '<script>alert("Missing form parameters!");</script>';
        echo '<script>window.location.href = "index.php";</script>';
        exit(); // Terminate script execution
    }
}
?>
