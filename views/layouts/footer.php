<footer id="footer"><!--Footer-->
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <p class="pull-left">Copyright © <?php echo date('Y');?></p>
                <p class="pull-right">Алексей</p>
            </div>
        </div>
    </div>
</footer><!--/Footer-->



<script src="/template/js/jquery.js"></script>
<script src="/template/js/bootstrap.min.js"></script>
<script src="/template/js/jquery.scrollUp.min.js"></script>
<script src="/template/js/price-range.js"></script>
<script src="/template/js/jquery.prettyPhoto.js"></script>
<script src="/template/js/main.js"></script>

<script>
    $(document).ready(function () {
        $(".add-to-cart").click(function () {
            let id = $(this).attr("data-id");
            $.post("/cart/addAjax/"+id, {}, function (data) {
                $("#cart-count").html(data);
            });
            return false;
        });
    });
</script>

<!--<script>-->
<!--// $(document).ready - говорит о том что код ниже надо выполнить-->
<!--// только после загрузки документа-->
<!--    $(document).ready(function () {-->
<!--// отвечает за нажатие кнопки "В корзину"-->
<!--// по клику на кнопку с class="add-to-cart" выпонять код ниже-->
<!--       $.(".add-to-cart").click(function() {-->
<!--// узнаем с каким id была нажата кнопка-->
<!--          let id = $(this).attr("data-id");-->
<!--// формируем асинх. запрос-->
<!--// /cart/addAjax/"+id - адрес на который мы отправим запрос-->
<!--// {} - параметры (пустые, т.к. id мы передаем в ссылке)-->
<!--// Далее функция которая обработает этот запрос-->
<!--          $.post("/cart/addAjax/"+id, {}, function (data) {-->
<!--              $("#cart-count").html(data);-->
<!--          });-->
<!--          return false;-->
<!--       });-->
<!--    });-->
<!--</script>-->
</body>
</html>
