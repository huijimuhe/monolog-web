/*global plupload */
function uploadImg(id, token) {
    Qiniu.uploader({
        runtimes: 'html5,flash,html4', //上传模式,依次退化
        browse_button: 'pick_' + id, //上传选择的点选按钮，**必需**
        uptoken_url: token, //Ajax请求upToken的Url，**强烈建议设置**（服务端提供）
        unique_names: true,
        domain: '[YOURS]', //bucket 域名，下载资源时用到，**必需**
        container: id + '-container', //上传区域DOM ID，默认是browser_button的父元素，
        max_file_size: '1mb', //最大文件体积限制
        flash_swf_url: 'js/plupload/Moxie.swf', //" {{asset('js/plupload/Moxie.swf')}}", //引入flash,相对路径
        max_retries: 3, //上传失败最大重试次数
        dragdrop: false, //开启可拖曳上传  
        chunk_size: '4mb', //分块上传时，每片的体积
        auto_start: true, //选择文件后自动上传，若关闭需要自己绑定事件触发上传, 
        init: {
            'FilesAdded': function(up, files) {
                plupload.each(files, function(file) {
                    $('#statue_' + id).show();
                    $('#overlay_' + id).show();
                });
            },
            'BeforeUpload': function(up, file) {
            },
            'UploadProgress': function(up, file) {
                $('#progress_'+id).attr('aria-valuenow', file.percent).css('width', file.percent + '%');
            },
            'FileUploaded': function(up, file, info) {
                var domain = up.getOption('domain');
                var res = $.parseJSON(info);
                var sourceLink = domain + res.key;
                $('#statue_' + id).hide();
                $('#overlay_' + id).hide();
                $('#img_' + id).show();
                $('#img_' + id).attr('src', sourceLink);
                $('#hidden_' + id).val(res.key);
            },
            'Error': function(up, err, errTip) {
                //上传出错时,处理相关的事情 
                $('#statue_' + id).hide();
                $('#overlay_' + id).hide();
                alert('图片上传失败'+err.message);
            },
            'UploadComplete': function() {
                //队列文件处理完毕后,处理相关的事情 
            },
            'Key': function(up, file) {
                // 若想在前端对每个文件的key进行个性化处理，可以配置该函数
                // 该配置必须要在 unique_names: false , save_key: false 时才生效
                var key = "";
                // do something with key here
                return key
            }
        }
    });
}  