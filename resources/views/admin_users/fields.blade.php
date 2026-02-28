<!-- Name Field -->
<div class="form-group col-sm-4">
    <label for="name">Name: <span class="text-danger">*</span></label>
    <input type="text" name="name" class="form-control" value="{{ old('name') }}">
    <small class="text-danger">{{ $errors->first('name') }}</small>
</div>

<!-- Email Field -->
<div class="form-group col-sm-4">
    <label for="email">Email: <span class="text-danger">*</span></label>
    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
    <small class="text-danger">{{ $errors->first('email') }}</small>
</div>

<!-- Mobile Number Field -->
<div class="form-group col-sm-4">
    <label for="MOP">Mobile Number: <span class="text-danger">*</span></label>
    <input type="number" name="MOP" class="form-control" value="{{ old('MOP') }}">
    <small class="text-danger">{{ $errors->first('MOP') }}</small>
</div>

<!-- Password Field -->
<div class="form-group col-sm-4">
    <label for="password">Password: <span class="text-danger">*</span></label>
    <input type="password" name="password" class="form-control">
    <small class="text-danger">{{ $errors->first('password') }}</small>
</div>

<!-- Type Field -->
<div class="form-group col-sm-6">
    <label for="TYPE">Type Of User <span class="text-danger">*</span></label>
    <select name="TYPE" class="form-control">
        <option value="1" {{ old('TYPE') == 1 ? 'selected' : '' }}>بائع او مؤجر</option>
        <option value="2" {{ old('TYPE') == 2 ? 'selected' : '' }}>مشتري أو مستأجر</option>
        <option value="3" {{ old('TYPE') == 3 ? 'selected' : '' }}>مطور عقاري</option>
    </select>
    <small class="text-danger">{{ $errors->first('TYPE') }}</small>
</div>

<!-- Age Field -->
<div class="col-md-6 form-group">
    <label for="AGE">Age</label>
    <select name="AGE" class="form-control">
        <option value="1" {{ old('AGE') == 1 ? 'selected' : '' }}>From 18 - to 25</option>
        <option value="2" {{ old('AGE') == 2 ? 'selected' : '' }}>From 26 to 35</option>
        <option value="3" {{ old('AGE') == 3 ? 'selected' : '' }}>From 36 to 45</option>
        <option value="4" {{ old('AGE') == 4 ? 'selected' : '' }}>From 46 to 60</option>
        <option value="5" {{ old('AGE') == 5 ? 'selected' : '' }}>More than 60</option>
    </select>
    <small class="text-danger">{{ $errors->first('AGE') }}</small>
</div>
