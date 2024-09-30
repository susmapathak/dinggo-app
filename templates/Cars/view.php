<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Car $car
 */
$this->assign('title', 'Car Details');
?>

<h2>Car Details</h2>

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
<h3>Quotes</h3>
<a href="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'importQuotes', $car->id]) ?>" class="button">Import Quotes</a>
<table>
    <thead>
        <tr>
            <th>Repairer</th>
            <th>Price</th>
            <th>Overview of Work</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($car->quotes as $quote): ?>
            <tr>
                <td><?= h($quote->repairer) ?></td>
                <td><?= h($quote->price) ?></td>
                <td><?= h($quote->overviewOfWork) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div>
  <a href="<?= $this->Url->build(['action' => 'index']) ?>">Back to Cars</a>
</div>
