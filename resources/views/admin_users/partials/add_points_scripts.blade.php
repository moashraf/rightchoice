{{-- ═══════════════════════════════════════════════════════════
     JavaScript: منطق modal إضافة النقاط + Export spinner
     يُضمَّن في: admin_users/index.blade.php  (قسم third_party_scripts)
════════════════════════════════════════════════════════════ --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ══════════════════════════════════════════════
    // Export button – spinner أثناء التصدير
    // ══════════════════════════════════════════════
    var exportBtn     = document.getElementById('export-users-btn');
    var exportText    = document.getElementById('export-users-text');
    var exportSpinner = document.getElementById('export-users-spinner');
    if (exportBtn) {
        exportBtn.addEventListener('click', function () {
            exportBtn.classList.add('disabled');
            exportText.style.display    = 'none';
            exportSpinner.style.display = '';
            setTimeout(function () {
                exportBtn.classList.remove('disabled');
                exportText.style.display    = '';
                exportSpinner.style.display = 'none';
            }, 5000);
        });
    }

    // ══════════════════════════════════════════════
    // Modal إضافة النقاط  –  AJAX كامل
    // ══════════════════════════════════════════════
    var currentPts = 0;
    var activeBtn  = null;
    var actionUrl  = '';

    // ── فتح الموديل وجلب أحدث البيانات ──────────
    document.querySelectorAll('.btn-add-points').forEach(function (btn) {
        btn.addEventListener('click', function () {
            activeBtn = this;
            actionUrl = this.dataset.action;
            var pointsUrl = this.dataset.pointsUrl;

            // ضبط الحالة الأولية
            document.getElementById('modal-user-name').textContent      = this.dataset.userName;
            document.getElementById('extra_points_input').value         = '';
            document.getElementById('points-preview').style.display     = 'none';
            document.getElementById('modal-error').style.display        = 'none';
            document.getElementById('modal-loading').style.display      = '';
            document.getElementById('modal-body-content').style.display = 'none';
            document.getElementById('confirmAddPoints').disabled        = true;

            $('#addPointsModal').modal('show');

            // جلب أحدث النقاط من السيرفر
            var token = (document.querySelector('meta[name="csrf-token"]') || {}).getAttribute?.('content') || '';

            fetch(pointsUrl, {
                method : 'GET',
                headers: {
                    'Accept'          : 'application/json',
                    'X-CSRF-TOKEN'    : token,
                    'X-Requested-With': 'XMLHttpRequest',
                },
            })
            .then(function (res) { return res.json(); })
            .then(function (data) {
                if (data.success) {
                    currentPts = data.current_points;
                    document.getElementById('modal-current-points').textContent = currentPts;
                    document.getElementById('modal-user-name').textContent      = data.user_name;
                    if (activeBtn) activeBtn.dataset.currentPoints = currentPts;
                }
            })
            .catch(function () {
                // Fallback: بيانات الصفحة
                currentPts = parseInt(activeBtn.dataset.currentPoints) || 0;
                document.getElementById('modal-current-points').textContent = currentPts;
            })
            .finally(function () {
                document.getElementById('modal-loading').style.display      = 'none';
                document.getElementById('modal-body-content').style.display = '';
                document.getElementById('confirmAddPoints').disabled        = false;
            });
        });
    });

    // ── معاينة الرصيد الجديد أثناء الكتابة ───────
    document.getElementById('extra_points_input').addEventListener('input', function () {
        var extra   = parseInt(this.value) || 0;
        var preview = document.getElementById('points-preview');
        var after   = document.getElementById('points-after');
        if (extra > 0) {
            after.textContent     = currentPts + extra;
            preview.style.display = '';
        } else {
            preview.style.display = 'none';
        }
    });

    // ── زر التأكيد – إرسال AJAX ──────────────────
    document.getElementById('confirmAddPoints').addEventListener('click', function () {
        var input      = document.getElementById('extra_points_input');
        var errorEl    = document.getElementById('modal-error');
        var extra      = parseInt(input.value);
        var confirmBtn = this;

        if (!extra || extra < 1) { input.focus(); return; }

        confirmBtn.disabled  = true;
        confirmBtn.innerHTML = '<i class="fas fa-spinner fa-spin ml-1"></i> جاري الحفظ...';
        errorEl.style.display = 'none';

        var token = (document.querySelector('meta[name="csrf-token"]') || {}).getAttribute?.('content') || '';

        fetch(actionUrl, {
            method : 'POST',
            headers: {
                'Content-Type'    : 'application/json',
                'Accept'          : 'application/json',
                'X-CSRF-TOKEN'    : token,
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({ extra_points: extra }),
        })
        .then(function (res) { return res.json(); })
        .then(function (data) {
            if (data.success) {
                if (activeBtn) activeBtn.dataset.currentPoints = data.new_points;
                $('#addPointsModal').modal('hide');
                showToast(data.message, 'success');
            } else {
                errorEl.textContent   = data.message || 'حدث خطأ، حاول مرة أخرى';
                errorEl.style.display = '';
            }
        })
        .catch(function () {
            errorEl.textContent   = 'حدث خطأ في الاتصال، حاول مرة أخرى';
            errorEl.style.display = '';
        })
        .finally(function () {
            confirmBtn.disabled  = false;
            confirmBtn.innerHTML = '<i class="fas fa-star ml-1"></i> إضافة النقاط';
        });
    });

    // ── Toast إشعار خفيف ──────────────────────────
    function showToast(msg, type) {
        var t = document.createElement('div');
        t.textContent   = msg;
        t.style.cssText = [
            'position:fixed', 'bottom:28px', 'left:50%',
            'transform:translateX(-50%)',
            'background:' + (type === 'success' ? '#16a34a' : '#dc2626'),
            'color:#fff', 'padding:12px 28px', 'border-radius:10px',
            'font-size:1rem', 'font-weight:600', 'z-index:9999',
            'box-shadow:0 4px 16px rgba(0,0,0,.18)', 'transition:opacity .4s',
        ].join(';');
        document.body.appendChild(t);
        setTimeout(function () {
            t.style.opacity = '0';
            setTimeout(function () { t.remove(); }, 500);
        }, 2800);
    }

});
</script>

