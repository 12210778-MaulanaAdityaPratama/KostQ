
<div class="mt-7">
    <form class="mx-auto w-full sm:w-1/2 mb-5" action="<?= base_url('home/search') ?>">
        <div class=" relative"><br>
            <input class ="form-grup" type="text" placeholder=" Ayo Cari Kost anda dan alamat kost yang anda cari Disini...." name="fr"
                class="form-input shadow-[0_0_4px_2px_rgb(31_45_61_/_10%)] bg-white rounded-full h-11 placeholder:tracking-wider"
                id="autocompleteInput" />
            <button type="submit"
                class="  absolute ltr:right-1 rtl:left-1 inset-y-0 m-auto rounded-full w-9 h-9 p-0 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="m18.031 16.617l4.283 4.282l-1.415 1.415l-4.282-4.283A8.96 8.96 0 0 1 11 20c-4.968 0-9-4.032-9-9s4.032-9 9-9s9 4.032 9 9a8.96 8.96 0 0 1-1.969 5.617m-2.006-.742A6.977 6.977 0 0 0 18 11c0-3.867-3.133-7-7-7s-7 3.133-7 7s3.133 7 7 7a6.977 6.977 0 0 0 4.875-1.975z" />
                </svg>
            </button>
            <div id="autocompleteResults"
                class="absolute left-0 mt-2 w-full bg-white border border-gray-300 rounded-md shadow-md hidden">
            </div>
        </div>
    </form>
    <?php if (empty($record)): ?>
        <h1 class="text-2xl dark:text-white"></h1>
    <?php else: ?>
        <h1 class="text-2xl dark:text-white"><?= count($record) ?> Kost Tesedia</h1>

    <?php endif ?>
</div>



