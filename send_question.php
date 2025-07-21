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
    
    // New fields for assessment data
    $assessment_score = htmlspecialchars(strip_tags(trim($_POST['assessment-score'] ?? '')));
    $assessment_answers = htmlspecialchars(strip_tags(trim($_POST['assessment-answers'] ?? '')));

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
    
    // Contact information
    $message .= "=== INFORMATIONS DE CONTACT ===\n";
    $message .= "Nom: $name\n";
    $message .= "Email: $email\n";
    $message .= "Téléphone: $phone\n\n";
    
    // Company information
    $message .= "=== INFORMATIONS ENTREPRISE ===\n";
    $message .= "Entreprise: $business\n";
    $message .= "Ancienneté de l'entreprise: $business_age\n";
    $message .= "Chiffre d'affaires: $turnover\n";
    $message .= "Nombre d'employés: $employees\n";
    $message .= "Activité principale: $business_type\n";
    $message .= "Besoin d'accompagnement: $support_needed\n\n";
    
    // Assessment results (if available)
    if ($assessment_score && $assessment_answers) {
        $message .= "=== RÉSULTATS DE L'ÉVALUATION ===\n";
        $message .= "Score obtenu: $assessment_score%\n";
        
        // Decode and format the answers
        $answers_data = json_decode($assessment_answers, true);
        if ($answers_data) {
            $questions = [
                1 => "Principal défi de croissance",
                2 => "Taille de l'entreprise", 
                3 => "Horizon de développement",
                4 => "Développement international",
                5 => "Type d'accompagnement recherché"
            ];
            
            $answer_labels = [
                'strategy' => 'Stratégie & Vision',
                'operations' => 'Optimisation Opérationnelle',
                'commercial' => 'Développement Commercial',
                'financial' => 'Financement & Trésorerie',
                'startup' => 'Start-up (0-1M€)',
                'growing' => 'PME en croissance (1-10M€)',
                'established' => 'ETI (10M€+)',
                'immediate' => 'Court terme (6-12 mois)',
                'medium' => 'Moyen terme (1-3 ans)',
                'long' => 'Long terme (3+ ans)',
                'yes-planning' => 'Oui, c\'est planifié',
                'yes-considering' => 'Oui, nous y réfléchissons',
                'no' => 'Non, focus domestique',
                'diagnosis' => 'Diagnostic & Audit',
                'implementation' => 'Mise en œuvre opérationnelle',
                'transformation' => 'Transformation complète'
            ];
            
            foreach ($answers_data as $questionNum => $answer) {
                $questionText = $questions[$questionNum] ?? "Question $questionNum";
                $answerText = $answer_labels[$answer] ?? $answer;
                $message .= "$questionText: $answerText\n";
            }
        }
        $message .= "\n";
    }

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