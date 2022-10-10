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
        var photoRequiredCheck = function () {
            setTimeout(function () {
                $('#photos').attr('required', $('.photo-item').length <= 0);
            }, 100)
        };

        photoRequiredCheck();

        $(document).on('change', '#photos', function () {
            var self = this;

            if (this.files.length > 20) {
                $(this).val('');
                return alert('选择的照片太多了');
            }

            const formData = new FormData();
            Array.prototype.forEach.call(this.files, function(file) {
                formData.append('photos[]', file);
            });

            const $message = $('#upload-message');
            var message = $message.text();
            $(this).attr('disabled', true);
            $message.text('正在处理中，请稍后...');
            axios.post('{{ route('photos.upload') }}', formData, {
                'Content-Type': 'multipart/form-data',
            }).then(function (result) {
                var html = '';
                var photos = result.data;
                var length = $('.photo-item').length;
                for (const k in photos) {
                    html += $('#photo-item-tpl').html()
                        .replace(/__index__/g, length + k)
                        .replace(/__id__/g, photos[k].id)
                        .replace(/__filename__/g, photos[k].filename.replace(/\$/g, '$$$$'))
                        .replace(/__url__/g, photos[k].url)
                        .replace(/__thumbnail_url__/g, photos[k].thumbnail_url);
                }
                $('#photo-items').append(html);
            }).catch(function (error) {
                alert('系统出现错误\r\n' + error.toString())
            }).finally(function () {
                $(self).attr('disabled', false).val('');
                $message.text(message);
                photoRequiredCheck();
            });
        });

        $(document).on('click', '.photo-remove', function () {
            var self = this;
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
