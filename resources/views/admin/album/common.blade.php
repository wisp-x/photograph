@push('scripts')
    <script type="text/html" id="photo-item-tpl">
        <div class="relative group photo-item">
            <a href="javascript:void(0)" class="absolute -top-4 -right-4 hidden group-hover:block photo-remove" data-id="__id__">
                <x-icons.close width="35" height="35" class="fill-red-500"></x-icons.close>
            </a>

            <div class="flex gap-2 h-24">
                <div class="h-full w-24 cursor-grab">
                    <img class="h-full w-full rounded-md object-center object-cover" data-url="__url__" src="__thumbnail_url__" alt="__filename__">
                </div>
                <x-textarea name="photos[__index__][intro]" class="resize-none h-full" rows="100%" placeholder="说说此照片的来历或拍摄时的心情吧～可为空"></x-textarea>
            </div>

            <input type="hidden" name="photos[__index__][id]" value="__id__">
            <input type="hidden" name="photos[__index__][filename]" value="__filename__">
            <input type="hidden" name="photos[__index__][thumbnail_url]" value="__thumbnail_url__">
            <input type="hidden" name="photos[__index__][url]" value="__url__">
        </div>
    </script>

    <script type="module">
        const sortable = Sortable.create(document.getElementById('photo-items'), {
            animation: 150,
            handle: '.cursor-grab',
        });

        // 刷新照片选择限制
        const photoRequiredCheck = function () {
            setTimeout(function () {
                $('#photos').attr('required', $('.photo-item').length <= 0);
            }, 100)
        };

        photoRequiredCheck();

        $(document).on('change', '#photos', function () {
            let self = this;

            if (this.files.length > 20) {
                $(this).val('');
                return alert('选择的照片太多了');
            }

            const queue = new Queue();

            const $message = $('#upload-message');
            let message = $message.text();
            $(self).attr('disabled', true);

            let i = this.files.length;
            Array.prototype.forEach.call(this.files, function(file) {
                queue.push(function (cb) {
                    $message.text('正在处理中，请不要关闭窗口，剩余 ' + i + ' 张图片，请稍后...');
                    axios.postForm('{{ route('photos.upload') }}', {
                        photo: file,
                    }).then(function (result) {
                        let html = '';
                        let photo = result.data;
                        html += $('#photo-item-tpl').html()
                            .replace(/__index__/g, $('.photo-item').length + 1)
                            .replace(/__id__/g, photo.id)
                            .replace(/__filename__/g, photo.filename.replace(/\$/g, '$$$$'))
                            .replace(/__url__/g, photo.url)
                            .replace(/__thumbnail_url__/g, photo.thumbnail_url);
                        $('#photo-items').append(html);
                    }).catch(function (error) {
                        console.error('系统出现错误\r\n' + error.toString())
                    }).finally(function () {
                        i--;
                        cb();
                    });
                });
            });

            queue.start(function () {
                $(self).attr('disabled', false).val('');
                $message.text(message);
                photoRequiredCheck();
            });
        });

        $(document).on('click', '.photo-remove', function () {
            let self = this;
            axios.delete('{{ route('photos.destroy') }}', {
                data: {id: $(this).data('id')},
            }).then(function () {
                $(self).closest('.photo-item').remove();
            }).catch(function () {
                alert('移除失败');
            }).finally(function () {
                photoRequiredCheck();
            });
        });
    </script>
@endpush
