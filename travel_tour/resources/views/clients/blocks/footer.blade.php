<!-- Footer Start -->
<style>

.footer{
    background:#0f172a;
    color:#e2e8f0;
    padding:60px 0 30px 0;
    margin-top:60px;
    font-family:Arial, Helvetica, sans-serif;
}

.footer-container{
    width:90%;
    max-width:1200px;
    margin:auto;
}

.footer-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:40px;
}

.footer h4{
    font-size:20px;
    margin-bottom:20px;
    color:#fff;
}

.footer-gallery{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:8px;
}

.footer-gallery img{
    width:100%;
    border-radius:6px;
    transition:0.3s;
}

.footer-gallery img:hover{
    transform:scale(1.08);
}

.newsletter p{
    font-size:14px;
    margin-bottom:15px;
}

.newsletter-form{
    display:flex;
    gap:10px;
}

.newsletter-form input{
    flex:1;
    padding:10px 14px;
    border:none;
    border-radius:6px;
}

.newsletter-form button{
    background:#3b82f6;
    border:none;
    padding:10px 16px;
    color:white;
    border-radius:6px;
    cursor:pointer;
    transition:0.3s;
}

.newsletter-form button:hover{
    background:#2563eb;
}

.footer-bottom{
    border-top:1px solid #334155;
    margin-top:40px;
    padding-top:20px;
    display:flex;
    justify-content:space-between;
    flex-wrap:wrap;
    font-size:14px;
}

.footer-menu a{
    color:#cbd5f5;
    margin-left:15px;
    text-decoration:none;
    transition:0.3s;
}

.footer-menu a:hover{
    color:#fff;
}

.back-to-top{
    position:fixed;
    right:25px;
    bottom:25px;
    width:45px;
    height:45px;
    background:#3b82f6;
    color:white;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    text-decoration:none;
    font-size:20px;
}

.back-to-top:hover{
    background:#2563eb;
}

</style>

<footer class="footer">

    <div class="footer-container">

        <div class="footer-grid">

            <!-- Gallery -->
            <div>
                <h4>Gallery</h4>

                <div class="footer-gallery">

                    <img src="{{ asset('clients/img/foodter1.jfif') }}">
                    <img src="{{ asset('clients/img/foodter2.jfif') }}">
                    <img src="{{ asset('clients/img/foodter3.jfif') }}">
                    <img src="{{ asset('clients/img/foodter4.jfif') }}">
                    <img src="{{ asset('clients/img/foodter5.jfif') }}">
                    <img src="{{ asset('clients/img/foodter6.jfif') }}">

                </div>
            </div>


            <!-- Newsletter -->
            <div class="newsletter">

                <h4>Newsletter</h4>

                <p>Đăng ký để nhận thông tin tour du lịch mới nhất.</p>

                <div class="newsletter-form">

                    <input type="email" placeholder="Nhập email của bạn">

                    <button>Đăng ký</button>

                </div>

            </div>

        </div>


        <!-- Bottom -->
        <div class="footer-bottom">

            <div>
                © {{ date('Y') }}
                <a href="{{ route('home') }}" style="color:#60a5fa;text-decoration:none">
                    Travel Tour
                </a>
                All Rights Reserved.
            </div>

            <div class="footer-menu">
                <a href="{{ route('home') }}">Home</a>
                <a href="#">Cookies</a>
                <a href="#">Help</a>
                <a href="#">FAQs</a>
            </div>

        </div>

    </div>

</footer>

<!-- Back To Top -->
<a href="#" class="back-to-top">↑</a>