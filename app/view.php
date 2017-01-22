<style>
    table {
        /*border: 1px solid black;*/ 
        border-collapse: collapse;
    }
    td {
        padding: 3px;
        border: 1px solid black;
    }
    .winner {
        background-color: #1f1;
    }
</style>
<table >
    <thead>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
    </thead>
    <tbody>
        <tr>
            <td <?php if (isset($table->winners['table'])): ?>class="winner"<?php endif ?>>Table cards</td>
            <?php
                foreach ($table->tableCards as $card): ?>
                    <td <?php 
                            foreach ($table->winners as $winner):
                                if ($winner['combination']->cardExists($card)): ?>
                                    class="winner"
                                <?php endif;  
                            endforeach;
                        ?>>
                        <?php echo $card->getName(); ?>
                    </td>
                <?php endforeach;
            ?>
        </tr>
        <?php foreach ($table->players as $player): ?>
            <tr>
                <td <?php if (isset($table->winners[$player->name])): ?>class="winner"<?php endif ?>><?php echo $player->name; ?> cards</td>
                <?php foreach ($player->cards as $card): ?>
                    <td <?php 
                            foreach ($table->winners as $winner):
                                if ($winner['combination']->cardExists($card)): ?>
                                    class="winner"
                                <?php endif;  
                            endforeach;
                        ?>>
                        <?php echo $card->getName(); ?>
                    </td>
                <?php endforeach ?>
            </tr>
            
        <?php endforeach ?>
    </tbody>
</table>
<br>
<?php 
    if (count($table->winners) == 1):
        foreach ($table->winners as $winner):
            echo $winner['winString']; 
        endforeach;
    else: 
        $i = 1;
        $count = count($table->winners);
        foreach ($table->winners as $winner):
            if ($i == $count) {
                echo 'Winner is '. $winner['winString'];
            } else {
                echo 'Winner is '. $winner['winString'] . '<br>';
            }
            $i++;
        endforeach;
    endif;
    
?>