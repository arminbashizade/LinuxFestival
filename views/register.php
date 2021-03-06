<?php
define('title','ثبت نام');
insertView('layout/header');
?>

<script src='https://www.google.com/recaptcha/api.js'></script>

<section id="register" class="container">

    <div style="text-align: center;">
        <h1>
            ثبت نام در هفتمین جشنواره‌ی لینوکس امیرکبیر
        </h1>
    </div>
    <hr>

    <?php

    if (isset($_REQUEST['ok'])) {

        $success = true;
        try {
            $msg = submit_reg_form();
        } catch (Exception $e) {
            $success = false;
        }
        ?>

        <?php if ($success): ?>
            <div class="alert alert-success">
                <?php echo $msg ?>
            </div>
        <?php else : ?>
            <div class="alert alert-danger">
                متاسفانه خطایی در هنگام ثبت نام رخ داد. لطفا این موضوع را گزارش دهید
            </div>
        <?php endif ?>

        <?php
        goto endform;
    }

    ?>

    <form class="col-md-7 col-sm-12" action="" method="POST">
        <fieldset>
            <legend>
                اطلاعات شخصی
            </legend>

            <!-- Fullname -->
            <label class="control-label col-md-3" for="name">*
                نام و نام خانوادگی
            </label>
            <input required="required" type="text" class="form-control input col-md-9" name="name" id="name">

            <span class="help-block col-md-offset-3">
                لطفا نام کامل خود را به صورت فارسی بنویسید.
            </span>

            <!-- Email -->
            <label class="control-label col-md-3" for="email">*
                Email
            </label>
            <input required="required" type="email" dir="ltr" class="form-control input col-md-9" name="email"
                   id="email">

            <span class="help-block col-md-offset-3">
از این آدرس جهت اطلاع رسانی جشنواره صرفا استفاده خواهد شد
            </span>


            <!-- Tel -->
            <label class="control-label col-md-3" for="tel">*
تلفن همراه
            </label>
            <input required="required" type="tel" dir="ltr" class="form-control input col-md-9" name="tel" id="tel">

            <span class="help-block col-md-offset-3">
                صرفا جهت اطلاع رسانی و تماس ضروری در صورت هرگونه مشکل
            </span>

            <div class="radio radio-info col-md-9">
                <input type="radio" id="std" name="std" value="std" checked="checked">
                <label class="control-label" for="std">
                    دانشجو/ دانش‌آموز هستم
                </label>
            </div>

            <div class="radio radio-info col-md-9">
                <input type="radio" id="aut" name="std" value="aut">
                <label class="control-label" for="aut">
                    دانشجوی امیرکبیر هستم
                </label>
            </div>


            <div class="radio radio-warning col-md-9">
                <input type="radio" id="xstd" name="std" value="">
                <label class="control-label" for="xstd">
                    هیچکدام
                </label>
            </div>

        </fieldset>

        <br>

        <?php $i = 1;
        foreach (get_reg_data() as &$day): ?>


            <fieldset>
                <legend><?php echo $day['title']; ?></legend>

                <p>
                    در این کارگاه شرکت می‌کنم:
                </p>


                <?php $j = 0;
                foreach ($day['items'] as $id => $title) : ?>
                    <div class="radio radio-inline_x radio-<?php echo $j == 0 ? 'warning' : 'info' ?>">
                        <input type="radio"
                               name="<?php echo "day$i" ?>" id="<?php echo 'day' . $i . "_$id" ?>"
                               value="<?php echo $id ?>"
                            <?php if ($j == 1) echo 'checked=checked' ?>
                            >
                        <label for="<?php echo 'day' . $i . "_$id" ?>">
                            <?php echo $title ?>
                        </label>
                        <?php if ($id != 'no') : ?>
                            <a target="popup" href='<?php echo viewUri("presentation?s=$id") ?>'>
                                (اطلاعات بیشتر)
                            </a>
                        <?php endif ?>
                    </div>
                    <?php $j++; endforeach ?>

                <br>

                <p>
                    در این ارایه ها شرکت می کنم :
                </p>


                <?php $j = 0;
                foreach ($day['presentations'] as $id) : ?>

                    <div class="presentation checkbox checkbox-success">
                        <input type="checkbox" checked="checked" value="X"
                               name='<?php echo $id ?>'>
                        <label class="control-label">
                            <?php echo get_presentations()[$id]['title'] ?>
                            <a target="popup" href='<?php echo viewUri("presentation?s=$id") ?>'>
                                (اطلاعات بیشتر)
                            </a>
                        </label>
                    </div>


                    <?php $j++; endforeach ?>


            </fieldset>
            <br>
            <?php $i++;
        endforeach ?>

        <br>

        <div class="alert alert-success">
            شرکت در ارائه‌ها رایگان است، اما با توجه به ظرفیت محدود آمفی‌تئاتر لطفا برای حضور در ارائه‌ها
            ثبت نام کنید. اولویت شرکت در ارائه‌ها با شرکت‌کنندگان کارگاه‌هاست.
        </div>


        <div class="alert alert-warning">
            هزینه ی شرکت در هرروز کارگاه ۳۵ هزارتومان هست
            <br>
            دانشجویان امیرکبیر از ۶۰٪ و دانشجویان دانشگاه‌های دیگر و دانش‌آموزان از ۲۵٪ تخفیف برخوردار
            می‌شوند.
        </div>

        <div class="alert alert-info">
            برای برخورداری از تخفیف، کارت دانشجویی یا دانش آموزی خود را در هنگام ثبت نام نهایی به همراه داشته باشید.<br>
        </div>

        <div id="submit_invalid" class="invalid alert-danger alert alert-dismissable"
             style="visibility:hidden;">
            دوره‌هایی که در آن‌ها شرکت می‌کنید با همدیگر همخوانی ندارند
            <br>
            باید دوره‌ی
            <span id="err_c"></span>
            را در هر دو روز انتخاب کنید
        </div>


        <div class="row">
            <div class="col-md-8">
                <div class="g-recaptcha" data-sitekey="6LeVkAUTAAAAAP6hsByUuc4nM3wKmSR7gtRk54qB"></div>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="row">
            <br>

            <div class="col-sm-offset-6">
                <input id="submit" name="ok" type="submit" class="btn btn-success btn-lg" value="ثبت نام">
            </div>

        </div>
    </form>

    <?php
    endform:
    ?>

</section>

<?php insertView('layout/footer'); ?>

<script>
    $('input[name="day1"]').change(update_presentations);
    $('input[name="day2"]').change(update_presentations);
    update_presentations();
</script>

