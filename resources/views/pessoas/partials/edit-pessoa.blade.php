<div class="form-group">
    <label for="cpf">CPF</label>
    <input id="cpf" type="text" class="form-control @error('cpf') is-invalid @enderror" name="cpf" value="{{ $cpf }}">
    @error('cpf')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<div class="form-group">
    <label for="nome">{{ __('Name') }}</label>
    <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror maiuscula" name="nome" value="{{ $nome }}">
    @error('nome')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<div class="form-group">
    <label for="nascimento">Nascimento</label>
    <input type='text' class="form-control @error('nascimento') is-invalid @enderror" id="nascimento" name="nascimento" value="{{ $nascimento }}">
    @error('nascimento')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<div class="form-group">
    <label for="sexo">Sexo</label>
    <select class="form-control @error('sexo') is-invalid @enderror" id="sexo" name="sexo">
        <option value=""> - - SELECIONE - - </option>
        <option value="F">FEMININO</option>
        <option value="M">MASCULINO</option>
    </select>
    @error('sexo')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<div class="form-group">
    <label for="telefone">Telefone/Celular</label>
    <input id="telefone" type="text" class="form-control @error('telefone') is-invalid @enderror" name="telefone" value="{{ $telefone }}">
    @error('telefone')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<div class="form-group">
    <label for="profissao">Profissão</label>
    <input id="profissao" type="text" class="form-control @error('profissao') is-invalid @enderror maiuscula" name="profissao" value="{{ $profissao }}">
    @error('profissao')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<div class="form-group">
    <label for="socio">É sócio do CEAL?</label>
    <select class="form-control @error('socio') is-invalid @enderror" id="socio" name="socio">
        <option value=""> - - SELECIONE - - </option>
        <option value="N">NÃO</option>
        <option value="S">SIM</option>
    </select>
    @error('socio')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<div class="form-group">
    <label for="bairro">Bairro</label>
    <input id="bairro" type="text" class="form-control @error('bairro') is-invalid @enderror maiuscula" name="bairro" value="{{ $bairro }}">
    @error('bairro')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
