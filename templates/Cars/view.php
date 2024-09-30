<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Car $car
 */
$this->assign('title', 'Car Details');
?>

<h1>Car Details</h1>

<table class="u-full-width">
  <tbody>
    <tr>
      <th>License Plate</th>
      <td><?= h($car->license_plate) ?></td>
    </tr>
    <tr>
      <th>License State</th>
      <td><?= h($car->license_state) ?></td>
    </tr>
    <tr>
      <th>VIN</th>
      <td><?= h($car->vin) ?></td>
    </tr>
    <tr>
      <th>Year</th>
      <td><?= h($car->year) ?></td>
    </tr>
    <tr>
      <th>Colour</th>
      <td><?= h($car->colour) ?></td>
    </tr>
    <tr>
      <th>Make</th>
      <td><?= h($car->make) ?></td>
    </tr>
    <tr>
      <th>Model</th>
      <td><?= h($car->model) ?></td>
    </tr>
  </tbody>
</table>

<div>
  <a href="<?= $this->Url->build(['action' => 'index']) ?>">Back to List</a>
</div>
