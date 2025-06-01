@section('title')
   Delivery Charge 
@endsection
@include('include.sidemenu')
@include('include.topmenu')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Delivery Charge Info</h3>
            </div>
        </div>
        <div class="card bd-info alert-info p-4">
            <div class="card-header">
                <h4 class="card-title">Order Information</h4>
            </div>
            <textarea name="name" rows="20" cols="45">

              অর্ডার করার জন্য নিচের তথ্য গুলো দিন,
                In English
                  * Name:
                  * Full Adress:
                  * Mobile Number:

              # ডেলিভারি চার্জ:
              ==============
                  * ঢাকা সিটির মধ্যে ডেলিভারি চার্জ 60 টাকা. (ক্যাশ অন ডেলিভরি)
                  * ঢাকার বাইরে ডেলিভারি চার্জ 100 - 150 টাকা (আগে বিকাশ করতে হবে)
                  * Gazipur, Saver, Naryanganj, Keraniganj ডেলিভারি চার্জ 100 টাকা (আগে বিকাশ করতে হবে)


              # ডেলিভারির সময়:
              ==============
                  * ঢাকা সিটির মধ্যে ২৪-৪৮ ঘণ্টা।
                  * ঢাকার বাইরে ২-৫ দিন।

              # ঢাকার বাইরে ডেলিভারি়:
              ==============
                  * PATHAO Curior Service - 100 Tk
                  * Sundorbon Curior Service - 130 Tk
                  * SA Poribahon - 150 tk
                  * REDX - 130 tk
            </textarea>

        </div>



    </div>
</div>
@include('include.footer')
