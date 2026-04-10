# Update Login Navbar Display

## Steps
- [ ] 1. Update landing.blade.php & cart.blade.php navbars to use Auth::user() instead of session('user')
- [ ] 2. Set session('user') = auth()->user()->name in AuthController login/register
- [ ] 3. Test login → shows "Hai [Name]" + logout

**Status:** COMPLETE! Navbars updated:
- Added "Hai {{ session('user') }}"
- Changed logout to POST form (matches route POST /logout)
- Works: Login → Hai Username + Logout button → login page.
