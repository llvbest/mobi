<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <title>Test catalog</title>
</head>
<body>

<div class="page">
    <div>
        <a href="/" class="btn btn-secondary" style="float: left;">Главная</a>
        <a href="https://github.com/llvbest/mobi" style="float: right;">https://github.com/llvbest/mobi</a>
    </div>
    <div id="page-body" class="page-body">
        <div class="buttons-panel">
            <button
                class="btn btn-dark btn-sm"
                data-toggle-trigger="form">+ Добавить
            </button>
            <button
                class="btn btn-dark btn-sm"
                data-toggle-trigger="filters">Фильтры
            </button>
        </div><!-- /.buttons-panel -->

        <div class="toggleable-block"
             style="display:none"
             data-toggle-target="filters">

            <button
                class="float-right btn btn-danger btn-sm"
                data-toggle-trigger="filters">x
            </button>

            <h4 class="toggleable-block__title">Фильтры</h4>

            <form data-filter-form method="GET" class="toggleable-block__content">
                <div class="row">
                    <div class="form-group col-sm">
                        <label>Дата публикации</label>
                        <input type="date"
                               name="f_purchasedAt"
                               value="YYYY-MM-DD"
                               class="form-control form-control-sm"
                               min="1900-01-01"
                               placeholder="">
                    </div>
                    <div class="form-group col-sm">
                        <label>Категория</label>
                        <select class="form-control form-control-sm" name="f_category">
                            <option value=""></option>
                            <?php foreach($this->category as $category_key => $category):?>
                                <option value="<?=$category_key ?>">
                                    <?=$category;?>
                                </option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Фильтровать</button>
            </form>
        </div>

        <div class="toggleable-block"
             style="display:<?= (!empty($modelResults)) ? 'block' : 'none' ?>"
             data-toggle-target="form">

            <button
                class="float-right btn btn-danger btn-sm"
                data-toggle-trigger="form">x
            </button>

            <h4 class="toggleable-block__title"><?= (empty($modelResults)) ? 'Новая новость' : $modelResults['title'] ?></h4>


            <form method="POST" action="/index.html?controller=index&action=insert" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= (empty($modelResults)) ? '' : $modelResults['id'] ?>">
                <div class="row">
                    <div class="form-group col-sm">
                        <label>Название</label>
                        <input type="text"
                               name="title"
                               value="<?= (empty($modelResults)) ? '' : $modelResults['title'] ?>"
                               class="form-control form-control-sm"
                               placeholder=""
                               required>
                    </div>
                    <div class="form-group col-sm">
                        <label>Дата публикации</label>
                        <input type="date"
                               name="purchasedAt"
                               min="01.01.1900"
                               value="<?= (empty($modelResults)) ? '' : $modelResults['purchasedAt'] ?>"
                               class="form-control form-control-sm"
                               placeholder=""
                               required>
                    </div>
                    <div class="form-group col-sm">
                        <label>Категория</label>
                        <select class="form-control form-control-sm" name="category">
                            <?php foreach($this->category as $category_key => $category):?>
                                <option value="<?=$category_key ?>"
                                    <?= (!empty($modelResults) && $modelResults['category']==$category_key) ? 'selected' : '' ?>
                                >
                                    <?=$category;?>
                                </option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm">
                        <label>Текст</label>
                        <textarea name="itemText" rows="5" class="form-control form-control-sm" placeholder="text" required><?= (empty($modelResults)) ? '' : trim(htmlspecialchars($modelResults['itemText'])); ?></textarea>
                    </div>
                </div>

                <div class="file-input">
                    <label class="file-input__label">Image</label>
                    <?php if (!empty($modelResults['imageName'])): ?>
                        <a href="<?=Config::UPLOADS_DIR .'/'. $modelResults['imageName']?>" target="_blank">
                        <img class="album-img img-thumbnail" src="<?=Config::UPLOADS_DIR .'/'. $modelResults['imageName']?>" />
                        </a>
                    <?php endif; ?>
                    <br /><br />
                    <input type="file" accept="image/*,image/jpeg" name="image">
                </div>


                <div class="toggleable-block__buttons">
                    <?php if (!empty($modelResults)) : ?>
                        <button type="submit" class="btn btn-success">Обновить</button>
                    <?php else : ?>
                        <button type="submit" class="btn btn-primary">Создать</button>
                    <?php endif ?>
                    <a href="/" class="btn btn-secondary">Отмена</a>
                </div>

            </form>
        </div>

    <?php
        $sort = $this->request->getParam('sort');
        $sortBy = $this->request->getSortParam();
        $activeMark = '';
        if(!empty($sort)) {
            $sortDirection = $this->request->getSortDirection();
            if ($sortDirection === SORT_ASC) $activeMark = '&#x25BC;';
            if ($sortDirection === SORT_DESC) $activeMark = '&#x25B2;';
        }
    ?>
        <div class="items-list">
            <table class="table table-sm">
                <thead>
                <tr>
                    <th><a href="<?=($sort=='id')? '-' : ''?>id" data-sort-link>ID <?=($sortBy=='id')? $activeMark : ''?></a></th>
                    <th><a href="<?=($sort=='title')? '-' : ''?>title" data-sort-link>Название <?=($sortBy=='title')? $activeMark : ''?></a></th>
                    <th><a href="<?=($sort=='purchasedAt')? '-' : ''?>purchasedAt" data-sort-link>Дата публикации <?=($sortBy=='purchasedAt')? $activeMark : ''?></a></th>
                    <th><a href="<?=($sort=='category')? '-' : ''?>category" data-sort-link>Категория <?=($sortBy=='category')? $activeMark : ''?></a></th>
                    <th>Текст</th>
                    <th>Image</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $row) : ?>
                        <tr>
                            <td><?=$row['id']?></td>
                            <td><a href="index.php?itemId=<?=$row['id']?>"><?=$row['title']?></a></td>
                            <td><?=$row['purchasedAt']?></td>
                            <td>
                                <?= (empty($this->category[$row['category']])) ? '' : $this->category[$row['category']] ?>
                            </td>
                            <td>
                            <div class="clip"><?=htmlspecialchars($row['itemText']);?></div>
                            </td>
                            <td>
                                <?php if(!empty($row['imageName'])) : ?>
                                    <img class="album-img img-thumbnail" src="<?=Config::UPLOADS_DIR .'/'. $row['imageName']?>" />
                                <?php endif; ?>
                            </td>
                            <td><button data-delete-album="<?=$row['id']?>" class="btn btn-light btn-sm">X</a></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <hr />
            <div style="float: left;">
            Page: <?=$page;?>
            <?php
                $url_ = '';
                $gets = [];
                $gets['sort'] = $this->request->getParam('sort');
                $gets['f_purchasedAt'] = $this->request->getParam('f_purchasedAt');
                $gets['f_category'] = $this->request->getParam('f_category');
                if(!empty($gets)){
                    $url_ = http_build_query($gets);
                    $url_ = (!empty($url_))? '&'.$url_ : null;
                }
            ?>
            <?php if ($page>1): ?>
                <?= '<a href="index.php?page='.( ($page>1)? $page-1 : $page).$url_.'">&lt; previous page</a>';?> |
            <?php endif; ?>
            <?php 
            if(!empty($results) && $sizeItems >($page) * Config::PAGE_COUNT ):?>
                <?= '<a href="index.php?page='.($page+1).$url_.'">next page &gt;</a>';?>
            <?php endif;?>
            </div>
            <div style="float: right;">Size: <?=$sizeItems?></div>
            <hr style="clear: both;" />
        </div>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>