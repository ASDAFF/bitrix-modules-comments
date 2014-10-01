
<!--reviews starts-->
<section class="reviews">
    <h2 class="heading">Комментарии</h2>

    <?if($arResult['OK']){?>
        <p>Спасибо за комментарий</p>
    <?}?>

    <?if($arResult['ERROR']){?>
        <p class="err">Ошибка: <?=$arResult['ERROR'];?></p>
    <?}?>
    <div class="btn-holder">
        <button class="btn alt otzyv_add">Добавить комментарий</button>
    </div>
    <div class="btn-holder otzyv_form">
        <form action="<?=$APPLICATION->GetCurPage();?>" method="POST" enctype="multipart/form-data">
            <textarea name="commment" placeholder="Комментарий"></textarea>
            <br>
            <input type="submit" class="btn alt" value="Добавить" name="add">
        </form>
    </div>
    <ul class="list">
        <?foreach($arResult['COMMENTS'] as $comment){ ?>
            <li>
                <div class="align-left">
                    <div class="box">
                        <strong class="name"><?=$comment['USER']["LOGIN"];?></strong>
                        <span class="date"><?=$comment['DATE_CREATE'];?></span>
                    </div>
                </div>
                <div class="align-right">
                    <p><?=$comment['PREVIEW_TEXT'];?></p>
                </div>
            </li>
        <?}?>

    </ul>
</section>
<!--reviews ends-->