html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Example: Browsing Files</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.25.0/ckeditor.js" integrity="sha512-BmPSKm+8FYKMlrIpuWJqTRPMPDI+2Ea55rS3g4EVP+Grh2GaP1e9MFjUNOLPasnOfq6puWIlqmAFllMxuE52Gg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js" integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function () {
            var funcNum = <?php echo $_GET['CKEditorFuncNum'].';'; ?>
            $('#fileExplorer').on('click','img', function(){
                window.opener.CKEDITOR.tools.callFunction( funcNum, fileUrl );
                window.close()
            }).hover(function () {
                $(this).css('cursor','pointer');
            })
        })
       
    </script>
    <style>
        ul.file-list{
            list-style: none;
            padding: 0;
            margin: 0;
        }
        ul.file-list li{
            float: left;
            margin: 5px;
            border: 1px solid #ddd;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div id="fileExplorer">
        @foreach ($fileNames as $file)
        
        <div class="thumbnail">
            <ul class="file-list">
                <li>
                <img src="{{asset('/uploads/ckeditor/'.$file)}}" alt="">
            <br>
            <span style="color:blue">{{$file}}</span>   
            </li>
            </ul>
        </div>
        @endforeach
    </div>
</body>
</html>