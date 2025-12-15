<footer class="footer-modern">
    <div class="container my-auto">
        <div class="copyright text-center">
            <span>&copy; {{ date('Y') }} SMA N 1 Sliyeg — Sistem Informasi Admin</span>
        </div>
    </div>
</footer>

@include('admin.layouts.logout-modal')

<style>
    .footer-modern {
    background: #f8f9fc;
    padding: 18px 0;
    border-top: 1px solid #e4e6ef;
    font-size: 14px;
    color: #6c757d;
}
.footer-modern span {
    font-weight: 500;
    letter-spacing: 0.3px;
}

</style>