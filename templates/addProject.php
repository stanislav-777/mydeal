<section class="content__side">
                <h2 class="content__side-heading">Проекты</h2>

                <nav class="main-navigation">
                    <ul class="main-navigation__list">
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
                    </ul>
                </nav>

                <a class="button button--transparent button--plus content__side-button"
                   href="/addProject.php" target="project_add">Добавить проект</a>
            </section>

            <main class="content__main">
            <h2 class="content__main-heading">Добавление проекта</h2>

            <form class="form"  action="addProject.php" method="post" autocomplete="off">
            <div class="form__row">
            <label class="form__label" for="project_name">Название <sup>*</sup></label>
            
            <input class="form__input" type="text" name="name" id="project_name" value="" placeholder="Введите название проекта">
            <?php if(!empty($errorText)) echo "<p class='form__message'>$errorText</p>";?>
        </div>

            <div class="form__row form__row--controls">
            <input class="button" type="submit" name="btn_add-project" value="Добавить">
            </div>
            </form>
    </main>

 