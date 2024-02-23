<div id="login">
        <h3 class="text-center text-white pt-5">Login form</h3>
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <?php
                             echo $this->Form->create('Users',array('class' => 'form','id' => 'login-form'));
                        ?>
                            <h3 class="text-center text-info">Login</h3>
                            <div class="form-group">
                                <?php echo $this->Flash->render() ?>
                            </div>
                            <div class="form-group">
                                <?=
                                    $this->Form->input('email',['label' => 'Email', 'class' => 'form-control','type' => 'email','required' => true]);
                                ?>
                            </div>
                            <div class="form-group">
                                <?=
                                    $this->Form->input('password',['label' => 'Password', 'class' => 'form-control','required' => true]);
                                ?>
                            </div>
                            <div class="form-group mt-3"> <input type="submit" name="submit" class="btn btn-info btn-md" value="submit">
                            </div>
                            <div class="text-right mt-3">
                            <?php echo $this->Html->link('Register Here',['controller' => 'users', 'action' => 'new'],['class' => 'text-info'])?>
                            </div>
                        <?php echo $this->Form->end();?>
                    </div>
                </div>
            </div>
        </div>
    </div>