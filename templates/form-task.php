      <section class="content__side">
        <h2 class="content__side-heading">Проекты</h2>

        <nav class="main-navigation">
         <?php
                        foreach ($masProject as $project){
                            if ($project['id'] == $idProject){
                            echo '<li class="main-navigation__list-item--active">
                            <a class="main-navigation__list-item-link" href="'.$project['href'].'">'.$project['name'].'</a>
                            <span class="main-navigation__list-item-count">'.$project['number'].'</span>
                            </li>';
                            }
                            else{
                                echo '<li class="main-navigation__list-item">
                                <a class="main-navigation__list-item-link" href="'.$project['href'].'">'.$project['name'].'</a>
                                <span class="main-navigation__list-item-count">'.$project['number'].'</span>
                                </li>';
                            }
                        }
                        ?>
        </nav>

        <a class="button button--transparent button--plus content__side-button" href="form-project.html">Добавить проект</a>
      </section>

      <main class="content__main">
        <h2 class="content__main-heading">Добавление задачи</h2>

        <form class="form"  action="add.php" method="post" autocomplete="off" enctype="multipart/form-data">
          <div class="form__row">
            <label class="form__label" for="name">Название <sup>*</sup></label>

            <input class="form__input <?php if(!empty($errorText4)) echo 'form__input--error';?>" type="text" name="name" id="name" value="<?php echo $_POST['name']; ?>" placeholder="Введите название">
            <?php if(!empty($errorText4)) echo "<p class='form__message'>$errorText4</p>";?>
        </div>
<!-- добить каждый пункт -->
          <div class="form__row">
            <label class="form__label" for="project">Проект <sup>*</sup></label>

            <select class="form__input form__input--select <?php if(!empty($errorText3)) echo 'form__input--error';?>" name="project" id="project">
            <?php if(!empty($errorText3)) echo "<p class='form__message'>$errorText3</p>";?>
                <?php
                foreach( $masProject as $project){
                    echo '<option value="'.$project['id'].'">'.$project['name'].'</option>';
                }
                ?>
            </select>
          </div>

          <div class="form__row">
            <label class="form__label" for="date">Дата выполнения</label>

            <input class="form__input form__input--date <?php if(!empty($errorText2)) echo 'form__input--error';?>" type="text" name="date" id="date" value="<?php echo $_POST['date']; ?>" placeholder="Введите дату в формате ГГГГ-ММ-ДД">
            <?php if(!empty($errorText2)) echo "<p class='form__message'>$errorText2</p>";?>
          </div>

          <div class="form__row">
            <label class="form__label" for="file">Файл</label>

            <div class="form__input-file">
              <input class="visually-hidden" type="file" name="file" id="file" value="">

              <label class="button button--transparent" for="file">
                <span>Выберите файл</span>
              </label>
            </div>
          </div>

          <div class="form__row form__row--controls">
            <input class="button" type="submit" name="submit_task" value="Добавить">
          </div>
        </form>
      </main>