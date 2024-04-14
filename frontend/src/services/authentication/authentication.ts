export const setToken = (token: string): void => {
    localStorage.setItem('token', token)
}

export const getToken = (): string|null => {
    return localStorage.getItem('token')
}

export const removeToken = (): void => {
    const token = getToken();
    if (token) {
        localStorage.removeItem('token')
    }
}

export const isAuthenticated = (): boolean => {
    return !!getToken();
}