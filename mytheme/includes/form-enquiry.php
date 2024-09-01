<div id="success_message" class="alert alert-success" style="display: none;"></div>


<form id="enquiry">
    <h2>Send an enquiry about <?php the_title(); ?></h2>


    <input type="hidden" name="registration" value="<?php the_field('registration'); ?>">

    <div class="form-group row mb-3">
        <div class="col-lg-6">
            <input type="text" name="fname" placeholder="First Name" class="form-control" required>
        </div>

        <div class="col-lg-6">
            <input type="text" name="lname" placeholder="Last Name" class="form-control" required>
        </div>

    </div>

    <div class="form-group row mb-3">
        <div class="col-lg-6">
            <input type="email" name="email" placeholder="Email Address" class="form-control" required>
        </div>

        <div class="col-lg-6">
            <input type="tel" name="phone" placeholder="Phone" class="form-control" required>
        </div>
    </div>

    <div class="form-group mb-3">
        <textarea name="enquiry" class="form-control" placeholder="Your Enquiry"></textarea>
    </div>

    <div class="form-group mb-3">
        <button type="submit" class="btn btn-success">Send your enquiry</button>
    </div>
</form>

<script>
    (function($) {
        $('#enquiry').submit(function(event) {
            event.preventDefault();
            var endpoint = '<?php echo admin_url("admin-ajax.php"); ?>';
            var form = $('#enquiry').serialize();
            var formdata = new FormData;

            formdata.append('action', 'enquiry');
            formdata.append('nonce', '<?php echo wp_create_nonce('ajax-nonce'); ?>')
            formdata.append('enquiry', form);

            /**
             * FormData 对象: 通常用于构建键值对来模拟表单数据
             * contentType: false: 以避免 jQuery 自动设置 Content-Type 标头
             * processData: false: 以避免 jQuery 对数据进行反序列化，保持数据原样
             */

            $.ajax(endpoint, {
                type: 'POSt',
                data: formdata,
                processData: false,
                contentType: false,
                success: function(res) {
                    $("#enquiry").fadeOut(200);

                    $("#success_message").text("Thanks for your enquiry").show();

                    $('#enquiry').trigger('reset');

                    $("#enquiry").fadeIn(500);
                },
                error: function(err) {
                    alert(err.responseJSON.data);
                }
            })
        })
    })(jQuery)
</script>