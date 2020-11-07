<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>Наименование</th>
            <th class="text-center">Цена</th>
            <th class="text-center">Количество</th>
            <th class="text-center">Сумма</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($session['cart'] as $id => $item): ?>
            <tr>
                <td><?= $item['name'] ?></td>
                <td class="text-center"><?= $item['qty'] ?></td>
                <td class="text-center"><?= $item['price'] ?></td>
                <td class="total text-center"><?= $item['qty'] * $item['price'] ?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3">Итого:</td>
            <td><?= $session['cart.qty'] ?></td>
        </tr>
        <tr>
            <td colspan="3">На сумму:</td>
            <td><?= $session['cart.sum'] ?></td>
        </tr>
        </tbody>
    </table>
</div>

