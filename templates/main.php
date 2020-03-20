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
                   href="pages/form-project.html" target="project_add">Добавить проект</a>
            </section>

            <main class="content__main">
                <h2 class="content__main-heading">Список задач</h2>

                <form class="search-form" action="index.php" method="post" autocomplete="off">
                    <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

                    <input class="search-form__submit" type="submit" name="" value="Искать">
                </form>

                <div class="tasks-controls">
                    <nav class="tasks-switch">
                        <a href="/" class="tasks-switch__item tasks-switch__item--active">Все задачи</a>
                        <a href="/" class="tasks-switch__item">Повестка дня</a>
                        <a href="/" class="tasks-switch__item">Завтра</a>
                        <a href="/" class="tasks-switch__item">Просроченные</a>
                    </nav>

                    <label class="checkbox">
                        <?php if($show_complete_tasks == 1)
                        {echo '<input class="checkbox__input visually-hidden" type="checkbox" checked>';}
                            else {'<input class="checkbox__input visually-hidden" type="checkbox">';}
                        
                        ?>
                        <span class="checkbox__text">Показывать выполненные</span>
                    </label>
                </div>

                <table class="tasks">
                        <?php
                        $flagTaskImportant = '';
                        foreach($masTask as $task){
                                if ((bool)($task['statusTask'])){
                                    if ($show_complete_tasks){
                                        if ((strtotime($task['deadline']) - time()) <=24*3600) {
                                            $flagTaskImportant = 'task--important';
                                        } else {
                                            $flagTaskImportant = '';
                                        }
                                echo '<tr class="tasks__item task task--completed '.$flagTaskImportant.'">
                                <td class="task__select">
                                <label class="checkbox task__checkbox"><input class="checkbox__input visually-hidden task__checkbox" type="checkbox" value="1">
                                <span class="checkbox__text">'.$task['nameTask'].'</span>
                                </label>
                                </td>
                                <td class="task__file">
                                <a class="download-link" href="#"></a>
                                </td>
                                <td class="task__date ">'.$task['deadline'].'</td>
                                <td class="task__controls"></td>
                                </tr>
                                ';
                                    }
                                    else {continue;}
                                }
                                else{
                                    if (strtotime($task['deadline']) - time() <=24*3600) {
                                        $flagTaskImportant = 'task--important';
                                    }
                                    else {
                                        $flagTaskImportant = '';
                                    }
                                    echo '<tr class="tasks__item task '.$flagTaskImportant.'">
                                    <td class="task__select">
                                    <label class="checkbox task__checkbox"><input class="checkbox__input visually-hidden task__checkbox" type="checkbox" value="1">
                                    <span class="checkbox__text">'.$task['nameTask'].'</span>
                                    </label>
                                    </td>
                                    <td class="task__file">
                                    <a class="download-link" href="#"></a>
                                    </td>
                                    <td class="task__date">'.$task['deadline'].'</td>
                                    <td class="task__controls"></td>
                                    </tr>
                                    ';
                                };
                            };
                            ?>                    
                </table>
            </main>