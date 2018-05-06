# Validator
Data validation based on rules

# Basic use
```sh
$validator = new class extends \Validator\Core\AbstractValidator {};

$validator->defineRules([
    'username' => 'max(50):min(4)',
    'other' => 'equals(username)'
]);

$data = ['username' => 'Kanfa', 'other' => 'Other'];

if ($validator->validate($data)) {
    // Action
} else {
    $errors = $validator->getErrors();
    // Error action
}
```