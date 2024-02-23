<div id="login">
        <h3 class="text-center text-white pt-5">Login form</h3>
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <?php
                             echo $this->Form->create('Users',array('class' => 'form','id' => 'login-form'));
                        ?>
                            <h3 class="text-center text-info">Register</h3>
                            <div class="form-group">
                                <?php echo $this->Flash->render() ?>
                            </div>
                            <div class="form-group">
                                <?php  
                                    echo $this->Form->input('fullname' ,array('label' => 'Fullname',"class" => "form-control"));
                                    if (!empty($this->validationErrors['User']['fullname'])) {
                                        echo '<div class="text-danger">' . $this->validationErrors['User']['fullname'][0] . '</div>';
                                    }
                                ?>
                            </div>
                            <div class="form-group">
                                <?php  
                                    echo $this->Form->input('email' ,array('label' => 'Email Address',"class" => "form-control"));
                                    if (!empty($this->validationErrors['User']['email'])) {
                                        echo '<div class="text-danger">' . $this->validationErrors['User']['email'][0] . '</div>';
                                    }
                                ?>
                            </div>
                            <div class="form-group">
                                <?php  
                                    echo $this->Form->input('password' ,array('label' => 'Password',"type" =>"password","class" => "form-control")); 
                                    if (!empty($this->validationErrors['User']['password'])) {
                                        echo '<div class="text-danger">' . $this->validationErrors['User']['password'][0] . '</div>';
                                    }
                                ?>
                            </div>
                            <div class="form-group">
                                <?php  
                                    echo $this->Form->input('confirm_password' ,array('label' => 'Confirm Password',"type" =>"password","class" => "form-control")); 
                                    if (!empty($this->validationErrors['User']['confirm_password'])) {
                                        echo '<div class="text-danger">' . $this->validationErrors['User']['confirm_password'][0] . '</div>';
                                    }
                                ?>
                            </div>
                            <div class="form-group mt-3"> 
                                 <?php  echo $this->Form->button('Register' ,array("label"=>"","type" =>"submit","class" => "btn btn-primary")); ?>
                            </div>
                            <div class="text-right mt-3">
                                <?php echo $this->Html->link('Login',['controller' => 'users', 'action' => 'login'],['class' => 'text-info'])?>
                            </div>
                        <?php echo $this->Form->end();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
