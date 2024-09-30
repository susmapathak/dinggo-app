<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\ORM\Query $cars
 */
$this->assign('title', 'Cars List');
?>

<h2>Cars List</h2>
<?= $this->Html->link('Import Cars', ['action' => 'import'], ['class' => 'button']) ?>
<table class="u-full-width">
  <thead>
      <tr>
        <th>License Plate</th>
        <th>License State</th>
        <th>Make</th>
    </tr>
</thead>
<tbody>
    <?php foreach ($cars as $car): ?>
        <tr>
          <td>
            <a href="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'view', $car->id]) ?>">
              <?= h($car->license_plate) ?>
            </a>
          </td>
          <td><?= h($car->license_state) ?></td>
          <td><?= h($car->make) ?></td>
        </tr>
    <?php endforeach; ?>
</tbody>
</table>