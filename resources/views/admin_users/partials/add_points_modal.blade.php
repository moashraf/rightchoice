{{-- ═══════════════════════════════════════════════════════════
     Modal: إضافة نقاط للمستخدم
     يُضمَّن في: admin_users/index.blade.php
════════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="addPointsModal" tabindex="-1" role="dialog"
     aria-labelledby="addPointsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:420px">
        <div class="modal-content border-0 shadow-lg" style="border-radius:16px;overflow:hidden">

            {{-- ── Header ── --}}
            <div class="modal-header text-white border-0 pb-0"
                 style="background:linear-gradient(135deg,#f7971e,#ffd200);padding:24px 24px 0">
                <div class="w-100 text-center">
                    <div class="mb-2" style="font-size:2.4rem"><i class="fas fa-star"></i></div>
                    <h5 class="modal-title font-weight-bold" id="addPointsModalLabel" style="font-size:1.2rem">
                        إضافة نقاط للمستخدم
                    </h5>
                    <p class="mb-0 mt-1 small" id="modal-user-name" style="opacity:.85"></p>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"
                        style="position:absolute;left:14px;top:12px;opacity:.8;font-size:1.4rem">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            {{-- ── Body ── --}}
            <div class="modal-body" style="padding:28px 28px 10px">

                {{-- Loading overlay --}}
                <div id="modal-loading" class="text-center py-4" style="display:none">
                    <i class="fas fa-spinner fa-spin fa-2x" style="color:#f59e0b"></i>
                    <div class="mt-2 text-muted small">جاري تحميل البيانات...</div>
                </div>

                {{-- Main content (hidden while loading) --}}
                <div id="modal-body-content">

                    {{-- بطاقة النقاط الحالية --}}
                    <div class="d-flex align-items-center justify-content-between p-3 mb-4"
                         style="background:#fff8e1;border:1px solid #ffe082;border-radius:12px">
                        <div>
                            <div class="text-muted small mb-1">النقاط الحالية</div>
                            <div class="font-weight-bold" id="modal-current-points"
                                 style="font-size:1.8rem;color:#f59e0b">0</div>
                        </div>
                        <div style="font-size:2.5rem;color:#fcd34d"><i class="fas fa-coins"></i></div>
                    </div>

                    <form id="addPointsForm" onsubmit="return false;">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="font-weight-bold text-dark mb-1">النقاط الإضافية</label>
                            <div class="input-group" style="border-radius:10px;overflow:hidden">
                                <div class="input-group-prepend">
                                    <span class="input-group-text border-0"
                                          style="background:#f3f4f6;color:#f59e0b;font-size:1.1rem">
                                        <i class="fas fa-plus-circle"></i>
                                    </span>
                                </div>
                                <input type="number" name="extra_points" id="extra_points_input"
                                       class="form-control border-0"
                                       style="background:#f3f4f6;font-size:1.1rem"
                                       min="1" placeholder="مثال: 50" required>
                            </div>
                        </div>

                        {{-- معاينة الرصيد الجديد --}}
                        <div class="text-center small text-muted mb-2" id="points-preview" style="display:none">
                            سيصبح الرصيد:
                            <span class="font-weight-bold text-success" id="points-after"
                                  style="font-size:1rem"></span>
                            نقطة
                        </div>

                        {{-- رسالة خطأ --}}
                        <div id="modal-error" class="alert alert-danger py-2 mt-2"
                             style="display:none;border-radius:8px"></div>
                    </form>
                </div>
            </div>

            {{-- ── Footer ── --}}
            <div class="modal-footer border-0" style="padding:10px 28px 22px;gap:8px">
                <button type="button" class="btn btn-light btn-block mb-1" data-dismiss="modal"
                        style="border-radius:10px;font-weight:600">إلغاء</button>
                <button type="button" id="confirmAddPoints" class="btn btn-block text-white"
                        style="background:linear-gradient(135deg,#f7971e,#ffd200);border:none;
                               border-radius:10px;font-weight:700;font-size:1rem">
                    <i class="fas fa-star ml-1"></i> إضافة النقاط
                </button>
            </div>

        </div>
    </div>
</div>

