<? if(isset($_GET["user"])) : ?>
    <table class="table fes-table table-condensed  table-striped" id="fes-product-list">
    <thead>
        <tr>
            <th><?php _e( 'Название', 'edd_fes' ); ?></th>
            <th><?php _e( 'Дата завершения', 'edd_fes' ); ?></th>
            <th><?php _e( 'Сумма заказа', 'edd_fes' ); ?></th>
            <th><?php _e( 'Доход клиента', 'edd_fes' ); ?></th>
            <th><?php _e( 'Ваш доход', 'edd_fes' ); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php

        $items = getUserStatistics($_GET["user"]);

        if (count($items) > 0 ){
            
            $download = edd_get_download($item->postId);

            foreach ( $items as $item ) : ?>
                <tr>
                    <td class = "fes-product-list-td"><?php echo $download->post_title; ?></td>
                    <td class = "fes-product-list-td"><?php echo $item->completeDate; ?></td>
                    <td class = "fes-product-list-td"><?php echo $item->sum; ?></td>
                    <td class = "fes-product-list-td"><?php echo $item->postOwnerSum; ?></td>
                    <td class = "fes-product-list-td"><?php echo $item->partnerSum; ?></td>
                </tr>
            <?php endforeach;
        } else {
            echo '<tr><td colspan="7" class = "fes-product-list-td" >'. "Нет заказов" .'</td></tr>';
        }
        ?>
    </tbody>
    </table>
<? else : ?>
    <table class="table fes-table table-condensed  table-striped" id="fes-product-list">
    <thead>
        <tr>
            <th><?php _e( 'Имя', 'edd_fes' ); ?></th>
            <th><?php _e( 'Дата регистрации', 'edd_fes' ); ?></th>
            <th><?php _e( 'Действия', 'edd_fes' ); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php

        $items = getPartnerUsers();

        if (count($items) > 0 ){
            foreach ( $items as $item ) : ?>
            <tr>
                <td class = "fes-product-list-td"><? echo $item->display_name ?></td>
                <td class = "fes-product-list-td"><? echo $item->user_registered ?></td>
                <td class = "fes-product-list-td">                
                    <a href="http://joberli.ru/messages/?user=<? echo $item->ID?>&tab=chat" class="tabs-button fa fa-comment-o" title="Связаться"></a>
                    <a href="?user=<? echo $item->ID?>" class="tabs-button fa fa-eye" title="Посмотреть статистику"></a>
                </td>
            </tr>
            <?php endforeach;
        } else {
            echo '<tr><td colspan="7" class = "fes-product-list-td" >Нет клиентов</td></tr>';
        }
        ?>
    </tbody>
    </table>
<? endif ?>