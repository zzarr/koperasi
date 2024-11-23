<div class="modal fade" id="modal-invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><span id="action-modal"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="invoice-form">
                @csrf
                <div class="modal-body">


                    <label for="payment-tanggal">Pilih tanggal Pembayaran:</label>
                    <select id="payment-tanggal" name="payment_tanggal" required class="form-control ">
                        <option value="" disabled selected>Loading...</option>
                    </select>


                    <div id="invoice-container" style="display: none;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>
                        Close</button>
                    <button type="submit" id="btn_form" class="btn btn-primary"><i class="fa fa-save"></i>
                        Cetak</button>
                </div>
            </form>
        </div>
    </div>
</div>
