type PreferenceType = {
    value: number,
    label: string
}
export const preferenceRequestParams = (data: PreferenceType[]) => {
    let arr: number[] = []
    data.forEach((d) => {
        arr.push(d.value)
    })

    return arr
}

export const categoryRequestParams = (categories: PreferenceType[]): string => {
    return formatParams(preferenceRequestParams(categories), 'categories')
}

export const sourceRequestParams = (sources: PreferenceType[]): string => {
    return formatParams(preferenceRequestParams(sources), 'sources')
}

const formatParams = (params: number[], name: string): string => {
    let formattedParams = ''
    if (params && params.length) {
        params.forEach((param, index) => {
            formattedParams += `${name}[]=${param}`

            if (index >= 0 && index < params.length - 1) {
                formattedParams += '&'
            }
        })
    }

    return formattedParams
}