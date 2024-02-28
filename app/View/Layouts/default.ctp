<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>

<head>
    <?php echo $this->Html->charset(); ?>
    <title>
        <?php echo $cakeDescription ?>:
        <?php echo $this->fetch('title'); ?>
    </title>
    <style>
    .chat-container {
        max-width: 100%;
        margin: 50px auto;
        padding: 0 30px;
    }

    .message-container {
        max-height: 500px;
        /* Set a maximum height for the container */
        overflow-y: auto;
        /* Enable vertical scrolling */
    }

    .message {
        display: flex;
        margin-bottom: 15px;
    }

    .avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 10px;
    }

    .message-bubble {
        background-color: #f0f0f0;
        padding: 10px 15px;
        border-radius: 20px;
        width: 100%;
    }

    .sender-name {
        font-weight: bold;
    }

    .received .message-bubble {
        background-color: #e7e7e7;
    }

    .sent .message-bubble {
        background-color: #0084ff;
        color: #fff;
    }

    .message-info {
        font-size: 0.8em;
        color: #888;
    }

    .btnRemoveMsg {
        top: 18px;
        right: 19px;
        position: absolute;
    }
    </style>
    <?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('bootstrap.min');
    echo $this->Html->css('font-awesome.min');
    echo $this->Html->css('sweetalert2.min');
		echo $this->Html->css('custom');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Dropdown
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#">Disabled</a>
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </nav>
    </div>
    <div class="container">
        <div class="header">
            <div class="row align-items-center">
                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                    <!-- Bg -->
                    <div class="pt-20 rounded-top"
                        style="background:url(https://bootdey.com/image/480x480/FF00FF/000000) no-repeat; background-size: cover;">
                    </div>
                    <div class="card rounded-bottom smooth-shadow-sm">
                        <div class="d-flex align-items-center justify-content-between
                  pt-4 pb-6 px-4">
                            <!-- avatar -->
                            <div class="d-flex align-items-center">
                                <div class="avatar-xxl avatar-indicators avatar-online me-2
                      position-relative d-flex justify-content-end
                      align-items-end mt-n10">
                                    <?php
                          $profilePicture = '/uploads/default.jpg';
                          if(!empty($userData['profile_photo'])){
                              $profilePicture  = '/uploads/'.$userData['profile_photo'];
                          }
                      ?>
                                    <img src="<?= $profilePicture; ?>" class="avatar-xxl
                        rounded-circle border border-2 " alt="Image">
                                    <a href="#!" class="position-absolute top-0 right-0 me-2">
                                        <img src="https://dashui.codescandy.com/dashuipro/assets/images/svg/checked-mark.svg"
                                            alt="Image" class="icon-sm">
                                    </a>
                                </div>
                                <!-- content -->
                                <div class="lh-1">
                                    <h2 class="mb-0"><?= $userData['fullname']?>
                                        <a href="#!" class="text-decoration-none">
                                        </a>
                                    </h2>
                                    <div class="">
                                        <?php if(!empty($userData['gender'])):?>
                                        <p class="mb-2 d-block">Gender: <?= $userData['gender']; ?></p>
                                        <?php endif; ?>
                                        <?php if(!empty($userData['birthdate'])):?>
                                        <p class="mb-2 d-block">Birthdate:
                                            <?php 
                                $bdate = $userData['birthdate'];
                                echo $this->Time->format($bdate, '%B %e, %Y');
                            ?>
                                        </p>
                                        <?php endif; ?>
                                        <p class="mb-2 d-block">Joined:
                                            <?php 
                            $joined = $userData['created_at'];
                            echo $this->Time->format($joined, '%B %e, %Y - %H:%M %p');
                        ?>
                                        </p>
                                        <p class="mb-2 d-block">Last Login:
                                            <?php 
                            $lastLoggedIn = $userData['last_logged_in'];
                            echo $this->Time->format($lastLoggedIn, '%B %e, %Y - %H:%M %p');
                        ?>
                                    </div>

                                </div>
                            </div>
                            <div>
                                <!-- button -->
                                <?= $this->Html->link('Edit Profile',['controller' => 'users', 'action' => 'edit'],['class' => 'btn btn-outline-primary d-none d-md-block']) ?>
                                <?= $this->Html->link('Logout',['controller' => 'users', 'action' => 'logout'],['class' => 'btn btn-outline-secondary d-none d-md-block mt-2']) ?>
                                <?= $this->Html->link('Change Password',['controller' => 'users', 'action' => 'changePassword'],['class' => 'btn btn-outline-secondary d-none d-md-block mt-2']) ?>
                            </div>
                        </div>
                        <!-- nav -->
                    </div>
                </div>
            </div>
        </div>
        <div class="container my-5">
            <?php
            echo $this->Flash->render();   
        ?>
            <?php echo $this->fetch('content'); ?>
        </div>
    </div>
    <?= $this->Html->script('sweetalert2.min.js');?>
</body>

</html>