<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $name = htmlspecialchars(strip_tags(trim($_POST['name'] ?? '')));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $phone = htmlspecialchars(strip_tags(trim($_POST['phone'] ?? '')));
    $business = htmlspecialchars(strip_tags(trim($_POST['business'] ?? '')));
    $business_age = htmlspecialchars(strip_tags(trim($_POST['business-age'] ?? '')));
    $turnover = htmlspecialchars(strip_tags(trim($_POST['turnover'] ?? '')));
    $employees = htmlspecialchars(strip_tags(trim($_POST['employees'] ?? '')));
    $business_type = htmlspecialchars(strip_tags(trim($_POST['business-type'] ?? '')));
    $support_needed = htmlspecialchars(strip_tags(trim($_POST['support-needed'] ?? '')));
    $form_title = htmlspecialchars(strip_tags(trim($_POST['form-title'] ?? 'Demande de consultation')));


    if (!$name || !$email || !$business || !$business_age || !$turnover || !$employees || !$business_type || !$support_needed) {
        // Required fields missing, redirect back or show error
        echo "Veuillez remplir tous les champs obligatoires.";
        exit;
    }

    // Recipient email
    $to = "molly.ho@khione.fr";

    // Email subject
    $subject = "Nouvelle demande de consultation";

    // Email content
    $message = "Vous avez reçu une nouvelle demande de consultation:\n\n";
    $message .= "Sujet du formulaire: $form_title\n\n";
    $message .= "Nom: $name\n";
    $message .= "Email: $email\n";
    $message .= "Téléphone: $phone\n";
    $message .= "Entreprise: $business\n";
    $message .= "Ancienneté de l'entreprise: $business_age\n";
    $message .= "Chiffre d'affaires: $turnover\n";
    $message .= "Nombre d'employés: $employees\n";
    $message .= "Activité principale: $business_type\n";
    $message .= "Besoin d'accompagnement: $support_needed\n";

    // Email headers
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Send email

if (mail($to, $subject, $message, $headers)) {
    echo '
    <div style="
        max-width: 600px; 
        margin: 40px auto; 
        padding: 20px; 
        border-radius: 12px; 
        background: #d4edda; 
        color: #155724; 
        font-family: Arial, sans-serif; 
        font-size: 1.2rem; 
        text-align: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    ">
        Merci pour votre demande, nous vous contacterons bientôt. Cette page vous redirigera dans 5 secondes
    </div>
    <script>
        setTimeout(function() {
            window.location.href = "contact.html";
        }, 5000);
    </script>
    ';
} else {
    echo '
    <div style="
        max-width: 600px; 
        margin: 40px auto; 
        padding: 20px; 
        border-radius: 12px; 
        background: #f8d7da; 
        color: #721c24; 
        font-family: Arial, sans-serif; 
        font-size: 1.2rem; 
        text-align: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    ">
        Une erreur est survenue lors de l\'envoi. Veuillez réessayer. Cette page vous redirigera dans 5 secondes
    </div>
    <script>
        setTimeout(function() {
            window.location.href = "contact.html";
        }, 5000);
    </script>
    ';
}
}
?>
