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
            <div class="modal-body">
                <form id="invoice-form">
                    @csrf
                    <label for="payment-id">Pilih Pembayaran:</label>
                    <select id="payment-id" name="payment_id" required class="form-control ">
                        <option value="" disabled selected>Loading...</option>
                    </select>
                    <button type="submit">Cetak Invoice</button>
                </form>
                <div id="invoice-container" style="display: none;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>
                    Close</button>
                <button type="button" id="btn_form" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
            </div>
        </div>
    </div>
</div>
