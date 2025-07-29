<?php
// Chemin vers la base SQLite (dans le même dossier que ce script)
$dbFile = __DIR__ . '/database.sqlite';
if (!is_writable(__DIR__)) {
    die("Le dossier " . __DIR__ . " n'est pas accessible en écriture.");
}
try {
    // Connexion à la base SQLite
    $db = new PDO('sqlite:' . $dbFile);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Création de la table si elle n'existe pas
    $db->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        email TEXT NOT NULL UNIQUE
    )");

    // Gestion des actions POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['add'])) {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            if ($name && $email) {
                $stmt = $db->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
                $stmt->execute([$name, $email]);
            }
        }
        if (isset($_POST['edit'])) {
            $id = (int)$_POST['id'];
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            if ($id && $name && $email) {
                $stmt = $db->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
                $stmt->execute([$name, $email, $id]);
            }
        }
        if (isset($_POST['delete'])) {
            $id = (int)$_POST['id'];
            if ($id) {
                $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
                $stmt->execute([$id]);
            }
        }
        // Redirection pour éviter le repost du formulaire au refresh
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }

    // Lecture des utilisateurs
    $stmt = $db->query("SELECT * FROM users ORDER BY id DESC");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erreur base de données : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>App Test </title>
    <style>
        table { border-collapse: collapse; width: 600px; }
        th, td { border: 1px solid #aaa; padding: 8px; text-align: left; }
        input[type=text], input[type=email] { width: 90%; padding: 5px; }
        form { margin: 0; }
        button { padding: 5px 10px; margin-right: 5px; }
    </style>
</head>
<body>

<h2>Ajouter un utilisateur</h2>
<form method="post">
    <input type="text" name="name" placeholder="Nom" required>
    <input type="email" name="email" placeholder="Email" required>
    <button type="submit" name="add">Ajouter</button>
</form>

<h2>Liste des utilisateurs</h2>
<table>
    <tr>
        <th>ID</th><th>Nom</th><th>Email</th><th>Actions</th>
    </tr>
    <?php foreach ($users as $user): ?>
    <tr>
        <form method="post">
            <td><?= htmlspecialchars($user['id']) ?></td>
            <td><input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required></td>
            <td><input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required></td>
            <td>
                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                <button type="submit" name="edit">Modifier</button>
                <button type="submit" name="delete" onclick="return confirm('Confirmer la suppression ?')">Supprimer</button>
            </td>
        </form>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>

