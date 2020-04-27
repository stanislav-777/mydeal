
        <section class="content__side">
          <p class="content__side-info">Если у вас уже есть аккаунт, авторизуйтесь на сайте</p>

          <a class="button button--transparent content__side-button" href="form-authorization.html">Войти</a>
        </section>

        <main class="content__main">
          <h2 class="content__main-heading">Регистрация аккаунта</h2>

          <form class="form" action="registration.php" method="post" autocomplete="off">
            <div class="form__row">
              <label class="form__label" for="email">E-mail <sup>*</sup></label>

              <input class="form__input <?php if(!empty($errorText1)) echo 'form__input--error';?>" type="text" name="email" id="email" value="<?php echo $_POST['email']; ?>" placeholder="Введите e-mail">

              <?php if(!empty($errorText1)) echo "<p class='form__message'>$errorText1</p>";?>
            </div>

            <div class="form__row">
              <label class="form__label" for="password">Пароль <sup>*</sup></label>

              <input class="form__input <?php if(!empty($errorText2)) echo 'form__input--error';?>" type="password" name="password" id="password" value="" placeholder="Введите пароль">
              <?php if(!empty($errorText2)) echo "<p class='form__message'>$errorText2</p>";?>
            </div>

            <div class="form__row">
              <label class="form__label" for="name">Имя <sup>*</sup></label>

              <input class="form__input <?php if(!empty($errorText3)) echo 'form__input--error';?>" type="text" name="name" id="name" value="<?php echo $_POST['name']; ?>" placeholder="Введите имя">
              <?php if(!empty($errorText3)) echo "<p class='form__message'>$errorText3</p>";?>
            </div>

            <div class="form__row form__row--controls">
            <?php if(!($validation)) echo "<p class='error-message'>Пожалуйста, исправьте ошибки в форме.</p>";?>

              <input class="button" type="submit" name="btn_reg" value="Зарегистрироваться">
            </div>
          </form>
        </main>
