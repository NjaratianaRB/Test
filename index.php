<?php 
require_once'class/Message.php';
require_once'class/GuestBook.php';
$errors = null;
$sucess = false;
$guestbook = new GuestBook(__DIR__ . DIRECTORY_SEPARATOR . 'data' .DIRECTORY_SEPARATOR .'message');
if (isset($_POST['username'],$_POST['message'])){
 $message = new Message($_POST['username'],$_POST['message'] );
 if ($message->isValid()){
    $guestbook->addMessage($message);
    $sucess= true;
    $_POST=[];
 }else{
    $errors=$message->getErrors();
 }
}
$message=$guestbook->getMessages();

$title = "Livre d'Or";
require "elements/header.php";
?>
<div class="container">
    <h1>Livre d'Or</h1>

    <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        Formulaire invalide
    </div>
    <?php endif ?>

    <?php if ($sucess): ?>
    <div class="alert alert-sucess">
        Merci pour votre message
    </div>
    <?php endif ?>

    <form action="" method="post">
        <div class="form-group">
            <input value="<?=htmlentities($_POST['username'] ?? "" )?>" type="text" name="username" placeholder="Votre Pseudo" id="username" class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?> ">
            <?php if (isset($errors['username'])):?>
            <div class="invalid-feedback"><?= $errors['username']?></div>
               <?php endif ?>
        </div>
        <div class="form-group">
            <textarea name="message" id="message" cols="20" rows="10" placeholder="Votre Message" class="form-control <?= isset($errors['message']) ? 'is-invalid' : '' ?> "><?= htmlentities($_POST['message'] ?? '')?></textarea>
            <?php if (isset($errors['message'])):?>
            <div class="invalid-feedback"><?= $errors['message']?></div>
               <?php endif ?>
        </div>
        <button class="btn btn primary">Envoyer</button>
    </form>

    <?php if (!empty($message)): ?>
    <h1 class="mt-4">Vos messages</h1>
    <?php foreach($message as $messages):?>
       <?= $messages->toHTML();?>
    <?php endforeach ?>
    <?php endif ?>
</div>
<?php 
require "elements/footer.php";
?>