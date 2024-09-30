<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\ORM\Query $cars
 */

use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;

$this->assign('title', 'Cars List');

$checkConnection = function (string $name) {
    $error = null;
    $connected = false;
    try {
        ConnectionManager::get($name)->getDriver()->connect();
        // No exception means success
        $connected = true;
    } catch (Exception $connectionError) {
        $error = $connectionError->getMessage();
        if (method_exists($connectionError, 'getAttributes')) {
            $attributes = $connectionError->getAttributes();
            if (isset($attributes['message'])) {
                $error .= '<br />' . $attributes['message'];
            }
        }
        if ($name === 'debug_kit') {
            $error = 'Try adding your current <b>top level domain</b> to the
                <a href="https://book.cakephp.org/debugkit/5/en/index.html#configuration" target="_blank">DebugKit.safeTld</a>
            config and reload.';
            if (!in_array('sqlite', \PDO::getAvailableDrivers())) {
                $error .= '<br />You need to install the PHP extension <code>pdo_sqlite</code> so DebugKit can work properly.';
            }
        }
    }

    return compact('connected', 'error');
};
?>
<header>
    <div class="container text-center">
        <h1>
            Welcome to DingGo App
        </h1>
        <p>Using only photos DingGo will get you quotes from local repairers near you.</p>
         <a href="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'index']) ?>" class="button button-lg">Browse Cars</a>
    </div>
</header>

<div class="row">
    <div class="column">
        <h4>Database Connection</h4>
        <?php
        $result = $checkConnection('default');
        ?>
        <ul>
        <?php if ($result['connected']) : ?>
            <li class="bullet success">Dinggo App is able to connect to the database.</li>
        <?php else : ?>
            <li class="bullet problem">Dinggo App is NOT able to connect to the database.<br /><?= h($result['error']) ?></li>
        <?php endif; ?>
        </ul>
    </div>
    <div class="column">
        <h4>API Connection</h4>
        <ul>
        <?php if (Plugin::isLoaded('DebugKit')) : ?>
            <li class="bullet success">DebugKit is loaded.</li>
            <?php
            $result = $checkConnection('debug_kit');
            ?>
            <?php if ($result['connected']) : ?>
                <li class="bullet success">DebugKit can connect to the database.</li>
            <?php else : ?>
                <li class="bullet problem">There are configuration problems present which need to be fixed:<br /><?= $result['error'] ?></li>
            <?php endif; ?>
        <?php else : ?>
            <li class="bullet problem">DebugKit is <strong>not</strong> loaded.</li>
        <?php endif; ?>
        </ul>
    </div>
</div>