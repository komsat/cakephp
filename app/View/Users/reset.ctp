<div class="users">
    <?= $this->Form->create('User') ?>
    <fieldset>
        <legend><?= __('Forgot password') ?></legend>
        <?= $this->Form->input('new_password',['type'=>'password']) ?>
        <?= $this->Form->input('confirm_password',['type'=>'password']) ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>