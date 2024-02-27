<div class="card">
  <div class="card-header">
    Edit Profile
  </div>
  <div class="card-body">
   <?php
        echo $this->Form->create('User', array( 'type' => 'file', 'url' => array('controller' => 'Users', 'action' => 'edit')));
   ?>
        <div class="form-group">
            <?php echo $this->Flash->render(); ?>
        </div>
        <div class="form-group text-center">
            <?php
                $profilePicture = '/uploads/default.jpg';
                if(!empty($userData['profile_photo'])){
                    $profilePicture  = '/uploads/'.$userData['profile_photo'];
                }
            ?>
            <img src="<?= $profilePicture; ?>" class="edit-image" alt="" id="imgPreview">
        </div>
        <div class="form-group">
            <label for="">Change Image:</label>
            <input type="file" name="data[Users][image]" id="image" accept="image/png, image/gif, image/jpeg" >
        </div>
        <div class="form-group">
            <label for="">Fullname</label>
            <input type="text" name="fullname" class="form-control" value="<?=$userData['fullname']?>">
            <?php
                if (!empty($this->validationErrors['User']['fullname'])) {
                    echo '<div class="text-danger">' . $this->validationErrors['User']['fullname'][0] . '</div>';
                }
            ?>
        </div>
        <div class="form-group">
            <label for="">Birthdate</label>
            <input type="date" class="form-control" name="birthdate" value="<?php echo $this->Time->format($userData['birthdate'], '%Y-%m-%d') ?>">
            <?php 
                if (!empty($this->validationErrors['User']['email'])) {
                    echo '<div class="error-message">' . $this->validationErrors['User']['email'][0] . '</div>';
                }
            ?>
        </div>
        <div class="form-group">
            <label for="">Gender</label>
            <div class="form-check">
                <input class="form-check-input" value="1" type="radio" name="gender" id="flexRadioDefault1" <?php echo isset($userData['gender']) && $userData['gender'] == 1 ? 'checked' :''; ?> >
                <label class="form-check-label" for="flexRadioDefault1">
                    Male
                </label>
                </div>
                <div class="form-check">
                <input class="form-check-input" value="2" type="radio" name="gender"  id="flexRadioDefault2" <?php echo isset($userData['gender']) && $userData['gender'] == 2 ? 'checked' :''; ?>>
                <label class="form-check-label" for="flexRadioDefault2">
                    Female
                </label>
            </div>
        </div>
        <div class="form-group">
            <?php
                echo $this->Form->textarea('hubby', array(
                    'value' => $userData['hubby'],
                    'class' => 'form-control', // Optional: Add CSS class
                    'rows' => '10', // Optional: Specify the number of rows
                    'cols' => '30', // Optional: Specify the number of columns
                    'label' => 'Hobby'
                ));
                
            ?>
           
        </div>
        <div class="form-group mt-2">
            <button type="submit" class="btn btn-success">Save</button>
        </div>
    <?php echo $this->Form->end(); ?>
  </div>
</div>
<script>
    $(document).ready(function(){
        $('#image').change(function(){
            var file = this.files[0];
            var reader = new FileReader();

            reader.onload = function(e){
                $('#imgPreview').attr('src',e.target.result);
            }
            reader.readAsDataURL(file);
        })
    })
</script>