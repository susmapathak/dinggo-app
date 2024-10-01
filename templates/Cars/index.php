<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\ORM\Query $cars
 */
$this->assign('title', 'Cars List');
?>
<div class="row">
  <div class="column column-50"><h2>Cars List</h2></div>

  <div class="column column-50"><a href="<?= $this->Url->build(['action' => 'import']) ?>" class="float-right button">Import Cars</a></div>
</div>

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