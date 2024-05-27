
        <br><br><br>
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#Buscador-est").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $.ajax({
                    url: "ins_Inter.php",
                    type: "POST",
                    data: {query: value, 
                        año: "2024", 
                        periodo: 1, 
                        cod_cur: 1,
                        cod_doc: $cod_doc
                    },
                    success: function(response) {
                        $("#est").html(response);
                    }
                });
            });
            $("#nomb_cur").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $.ajax({
                    url: "loader.php",
                    type: "POST",
                    data: {query: value},
                    success: function(response) {
                        $("#content").html(response);
                    }
                });
            });
        });
    </script>
    
    <footer>
    </footer>

</html>