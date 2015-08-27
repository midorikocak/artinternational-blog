<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Public
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('foundation.css') ?>
    <?= $this->Html->css('foundation-icons.css') ?>
    <?= $this->Html->css('public.css') ?>
    <?= $this->Html->css('slick.css') ?>
    <?= $this->Html->css('slick-theme.css') ?>
    <?= $this->Html->css('blog.css') ?>

    <?= $this->Html->css('quill.snow.css') ?>


    <?= $this->Html->script('vendor/modernizr'); ?>
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Oswald:400,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Playfair+Display:400,400italic,700,700italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

    <link href='http://fonts.googleapis.com/css?family=PT+Serif:400italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Yantramanav:900&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
  <header class="fixed">
    <nav class="top-bar expanded" data-topbar role="navigation">
        <ul class="title-area large-3 medium-4 colmuns">
            <li class="name">
                <h1><a href="<?= $serverUrl ?>"><?= $site['title'] ?></a></h1>
            </li>
            <!-- <li class="toggle-topbar menu-icon"><a href="#"><span></span></a></li> -->
        </ul>
        <section class="top-bar-section right">
          <?= $this->element('user') ?>
        </section>
        <section class="top-bar-section right">
        <?php
          echo $this->cell('Menu');
        ?>
      </section>
    </nav>
  </header>

<main>
    <?= $this->Flash->render() ?>
    <div class="row">
    <section class="container clearfix">
        <?= $this->fetch('content') ?>
    </section>
  </div>
</main>

    <footer>
    <?= $this->element('social',['social'=>$social]) ?>
    </footer>

    <?= $this->Html->script('vendor/jquery'); ?>
    <?= $this->Html->script('foundation.min'); ?>
    <?= $this->Html->script('foundation/foundation.dropdown'); ?>
    <?= $this->Html->script('dropzone'); ?>
    <script>
    $(document).foundation();
    </script>
    <?= $this->fetch('scriptBottom') ?>
</body>
</html>
