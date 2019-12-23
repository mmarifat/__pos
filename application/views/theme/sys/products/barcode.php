<?php
/**
 * Author Minhaz Ahamed<mma.rifat66@gmail.com>
 * Email: mma.rifat66@gmail.com
 * Web: https://mma.champteks.us
 * Do not edit file without permission of author
 * All right reserved by Minhaz Ahamed<mma.rifat66@gmail.com>
 * Created on: 12/3/2019 8:51 PM
 */

?>
<div class="row justify-content-center">
    <div class="col-10">
        <div class="card">
            <div class="row justify-content-center mb-2 p-3">
                <div class="col-auto">
                    <label class="text-bold-700 font-size-base"> Barcode [<?= $genBarcode->name ?>]</label>
                </div>
            </div>

            <div class="row justify-content-center">
				<?php for ($i = 0; $i < 18; $i++) { ?>
                    <div class=" col-2 mb-4 pr-0 pl-0">
                        <img style="text-align:center; width: 100%;"
                             src="<?= sysUrl("bc/" . $genBarcode->code) ?>" alt="<?= $genBarcode->code ?>">
                    </div>
				<?php } ?>

            </div>
        </div>

        <div class="row p-1">
            <div class="col-md-12 text-center col-sm-12 noprint">
                <button type="button" onclick="window.close()"
                        class="btn btn-red my-1">
                    <i class="fa fa-close"></i> CLOSE
                </button>
                <button type="button" onclick="window.print()"
                        class="btn btn-grey-blue my-1">
                    <i class="fa fa-print"></i> PRINT
                </button>
            </div>
        </div>

    </div>
</div>
