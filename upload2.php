<html>
    <head>
        <title>Upload Chunk</title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/plupload/3.1.3/plupload.full.min.js"></script>
        <script>
            window.addEventListener("load",function(){
                var uploader = new plupload.Uploader({
                    runtimes: "html5,html4",
                    browse_button: "pickfiles",
                    url:"2b-chunk.php",
                    chunk_size:"4mb",
                    init:{
                        PostInit: function(){
                            document.getElementById("filelist").innerHTML = "";
                        },
                        FilesAdded: function(up, files){
                            plupload.each(files, function(file){
                                document.getElementById("filelist").innerHTML +=`<div id="${file.id}">${file.name} (${plupload.formatSize(file.size)}) - <strong>0%</strong></div>`;
                            });
                            uploader.start();
                        },
                        UploadProgress: function(up, file){
                            document.querySelector(`#${file.id} strong`).innerHTML = `${file.percent}%`;
                        },
                        Error: function(up, err){
                            console.log(err);

                        }
                    }
                });
                uploader.init();
            });
        </script>
    </head>
    <body>
        <!-- UPLOAD Form -->
        <div id="container">
            <span id="pickfiles">[upload Files]</span>
        </div>

        <!-- Upload File List -->
        <div id="filelist"></div>
    </body>
</html>