//@flow
/**
 * ==================================================
 * Developer: Alexey Nazarov
 * E-mail: jc1988x@gmail.com
 * Copyright (c) 2019 - 2022
 * ==================================================
 * "Bit.Umc - Bitrix integration" - functions.js
 * 10.07.2022 22:37
 * ==================================================
 */

/**
 * add phone mask
 * @param input
 * @param mask
 */
export function maskInput(input: HTMLInputElement, mask: string): void
{
    const value = input.value;
    const literalPattern = /[0]/;
    const numberPattern = /[0-9]/;

    let newValue = "";

    let valueIndex = 0;

    for (let i = 0; i < mask.length; i++) {
        if (i >= value.length) break;
        if (mask[i] === "0" && !numberPattern.test(value[valueIndex])) break;
        while (!literalPattern.test(mask[i])) {
            if (value[valueIndex] === mask[i]) break;
            newValue += mask[i++];
        }
        newValue += value[valueIndex++];
    }

    input.value = newValue;
}

export function convertHexToHsl(hex: string): any {
    const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);

    if (result)
    {
        let r = parseInt(result[1], 16);
        let g = parseInt(result[2], 16);
        let b = parseInt(result[3], 16);

        r /= 255; g /= 255; b /= 255;
        const max = Math.max(r, g, b), min = Math.min(r, g, b);
        let h = 0, s, l = (max + min) / 2;

        if (max === min) {
            h = s = 0; // achromatic
        } else {
            const d = max - min;
            s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
            switch (max) {
                case r:
                    h = (g - b) / d + (g < b ? 6 : 0);
                    break;
                case g:
                    h = (b - r) / d + 2;
                    break;
                case b:
                    h = (r - g) / d + 4;
                    break;
            }
            h /= 6;
        }

        s = s*100;
        s = Math.round(s);
        l = l*100;
        l = Math.round(l);
        h = Math.round(360*h);

        //`hsl(${h}, ${s}%, ${l}%)`
        return {
            h: h,
            s: `${s}%`,
            l: `${l}%`,
        };
    }
    return null;
}