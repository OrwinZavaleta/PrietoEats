/**
 * Prieto Eats — Validación reactiva de formularios
 * Muestra los errores en tiempo real según las mismas reglas del backend.
 *
 * Uso:
 *   PrietoValidation.init(formElement, { campo: [ regla, ... ] })
 *
 * Reglas: 'required', 'email', ['min', 8], ['max', 255],
 *         'numeric', ['minVal', 0.01], 'confirmed',
 *         ['fileTypes', ['jpg','png']], ['fileMax', 2048],
 *         'date', ['dateMin', '2026-01-01'],
 *         ['custom', (val, form) => '' | 'mensaje error']
 */
const PrietoValidation = (() => {
    'use strict';

    const $ = (s, c = document) => c.querySelector(s);

    /* ── Validadores (devuelven '' si OK, o el mensaje de error) ── */
    const V = {
        required : v => String(v ?? '').trim() ? '' : 'Este campo es obligatorio.',
        email    : v => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v) ? '' : 'El formato del correo no es válido.',
        min      : (v, n) => v.length >= n ? '' : `Debe tener al menos ${n} caracteres.`,
        max      : (v, n) => v.length <= n ? '' : `No puede superar los ${n} caracteres.`,
        numeric  : v => !isNaN(parseFloat(v)) && isFinite(v) ? '' : 'Debe ser un valor numérico.',
        minVal   : (v, n) => parseFloat(v) >= n ? '' : `El valor mínimo es ${n}.`,
        confirmed: (v, _, form) => {
            const base = $('[name="password"]', form);
            return base && base.value === v ? '' : 'Las contraseñas no coinciden.';
        },
        fileTypes: (v, types, _, inp) => {
            if (!inp?.files?.length) return '';
            const ext = inp.files[0].name.split('.').pop().toLowerCase();
            return types.includes(ext) ? '' : `Formatos permitidos: ${types.join(', ')}.`;
        },
        fileMax: (v, kb, _, inp) => {
            if (!inp?.files?.length) return '';
            return inp.files[0].size / 1024 <= kb ? '' : `Máximo ${kb >= 1024 ? (kb/1024)+'MB' : kb+'KB'}.`;
        },
        date   : v => !isNaN(Date.parse(v)) ? '' : 'Introduce una fecha válida.',
        dateMin: (v, min) => new Date(v) >= new Date(min) ? '' : `La fecha debe ser ${min} o posterior.`,
        custom : (v, fn, form, inp) => fn(v, form, inp),
    };

    /* ── Obtener / crear el <div> de error bajo el input ── */
    function feedbackOf(input) {
        if (input._fb) return input._fb;
        const el = document.createElement('div');
        el.className = 'text-danger small mt-1';
        el.style.display = 'none';
        const anchor = input.closest('.input-group') || input;
        anchor.parentNode.insertBefore(el, anchor.nextSibling);
        return (input._fb = el);
    }

    /* ── Ejecutar reglas sobre un campo ── */
    function check(input, rules, form) {
        const val = input.value;
        let error = '';

        for (const r of rules) {
            let name, param;
            if (typeof r === 'string')       { name = r; }
            else if (Array.isArray(r))        { [name, param] = r; }
            else                              { name = r.name; param = r.param; }

            const fn = V[name];
            if (!fn) continue;
            error = fn(val, param, form, input);
            if (error) break;
        }

        const fb = feedbackOf(input);
        if (error) {
            input.classList.add('is-invalid');
            input.classList.remove('is-valid');
            fb.textContent = error;
            fb.style.display = '';
        } else {
            input.classList.remove('is-invalid');
            if (String(val).trim()) input.classList.add('is-valid');
            else                     input.classList.remove('is-valid');
            fb.style.display = 'none';
        }
        return !error;
    }

    /* ── Inicializar formulario ── */
    function init(formSel, rulesMap) {
        const form = typeof formSel === 'string' ? $(formSel) : formSel;
        if (!form) return;

        const fields = {};

        for (const [name, rules] of Object.entries(rulesMap)) {
            const input = $(`[name="${name}"]`, form);
            if (!input) continue;
            fields[name] = { input, rules };

            // Validar en tiempo real al escribir o cambiar
            ['input', 'change', 'blur'].forEach(ev =>
                input.addEventListener(ev, () => check(input, rules, form))
            );
        }

        // Al enviar, validar todo y bloquear si hay errores
        form.addEventListener('submit', e => {
            let ok = true;
            for (const { input, rules } of Object.values(fields)) {
                if (!check(input, rules, form)) ok = false;
            }
            if (!ok) {
                e.preventDefault();
                e.stopPropagation();
                const first = form.querySelector('.is-invalid');
                if (first) first.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
    }

    return { init, check };
})();
