<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css(['bootstrap.min.css', 'all.min.css', 'main.css']) ?>


    <?= $this->Html->script(['jquery.min.js', 'moment.min.js', 'daterange.min.js', 'main.js']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body class="bg-white">
    <header class="position-absolute container-fluid border-bottom" style="height:50px;top:0;">
        <div class="row container-fluid mx-auto">
            <div class="col-3 pl-0">
                <?= $this->Html->image('logo.png', ['class' => 'img-fluid', 'style' => 'height: 50px','url' => ['controller' => 'Start', 'action' => 'index']]); ?>
            </div>
            <div class="col-6">
                <div class="input-group input-group-sm m-2">
                    <input type="text" class="bg-light pl-3 border-secondary-light text-dark form-control" placeholder="City, country or zip-code">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary pl-3 pr-3" type="button">
                            <i class="fab fa-sistrix"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-3 text-right">
                <a href="#" class="text-dark p-2">
                    Log in
                </a>
                <a href="#" class="btn btn-sm btn-dark m-2 mr-3">
                    <i class="fas fa-sign-in-alt pr-2"></i>Sign up
                </a>
            </div>
        </div>
    </header>
    <main class="mt-5 pt-1">
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </main>
    <footer>
    </footer>
</body>
</html>
