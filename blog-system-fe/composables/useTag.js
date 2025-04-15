export default function useTag() {
    const tagTitle = useState("title-tag", () => null)

    function setTagTitle(params) {
        tagTitle.value = params
    }

    return {
        tagTitle,
        setTagTitle
    }
}